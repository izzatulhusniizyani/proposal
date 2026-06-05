<?php

namespace App\Http\Controllers;

use App\Models\StudyGroup;
use App\Models\HelpRequest;
use App\Models\Reply;
use App\Models\Attendance;
use App\Models\Rating;
use App\Models\GroupChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $studyGroups = StudyGroup::with('user', 'users', 'chatMessages')->latest()->get();
        $myGroups = StudyGroup::where('user_id', $user->id)->with('user', 'users', 'chatMessages')->latest()->get();

        $helpRequests = HelpRequest::with('user', 'responses')->latest()->get();
        $myHelpRequests = HelpRequest::where('user_id', $user->id)->latest()->get();

        $totalActiveGroups = StudyGroup::where('status', 'upcoming')->count();
        $totalJoinedSessions = StudyGroup::sum('joined_count');
        $openHelpRequests = HelpRequest::where('status', 'open')->count();
        $trackedCourses = StudyGroup::distinct('course_code')->count('course_code');

        $userCourseCodes = $studyGroups->pluck('course_code')->unique()->take(5);
        $recommended = StudyGroup::with('user')
            ->whereIn('course_code', $userCourseCodes)
            ->where('status', 'upcoming')
            ->where('user_id', '!=', $user->id)
            ->latest()
            ->take(4)
            ->get();

        $myAttendance = Attendance::whereIn('study_group_id', $studyGroups->pluck('id'))
            ->latest()
            ->get();

        $myRatings = Rating::where('user_id', $user->id)
            ->with('studyGroup')
            ->latest()
            ->get();

        $joinedGroupIds = $user->joinedGroups->pluck('id')->toArray();

        return view('dashboard.index', [
            'studyGroups' => $studyGroups,
            'myGroups' => $myGroups,
            'helpRequests' => $helpRequests,
            'myHelpRequests' => $myHelpRequests,
            'stats' => [
                'totalActiveGroups' => $totalActiveGroups,
                'totalJoinedSessions' => $totalJoinedSessions,
                'openHelpRequests' => $openHelpRequests,
                'trackedCourses' => $trackedCourses,
            ],
            'recommended' => $recommended,
            'myAttendance' => $myAttendance,
            'myRatings' => $myRatings,
            'joinedGroupIds' => $joinedGroupIds,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => ['required', 'string', 'max:20'],
            'topic' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:500'],
            'date' => ['required', 'date'],
            'time' => ['required', 'string', 'max:10'],
            'participant_limit' => ['required', 'integer', 'min:1', 'max:100'],
            'material' => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg,webp', 'max:10240'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['joined_count'] = 0;
        $validated['status'] = 'upcoming';

        if ($request->hasFile('material')) {
            $path = $request->file('material')->store('study-materials', 'public');
            $validated['material_path'] = $path;
        }

        StudyGroup::create($validated);

        return redirect()->route('dashboard')->with('success', 'Study group created successfully!');
    }

    public function update(Request $request, StudyGroup $studySession)
    {
        if ($studySession->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'course_code' => ['required', 'string', 'max:20'],
            'topic' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:500'],
            'date' => ['required', 'date'],
            'time' => ['required', 'string', 'max:10'],
            'participant_limit' => ['required', 'integer', 'min:1', 'max:100'],
            'material' => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg,webp', 'max:10240'],
        ]);

        if ($request->hasFile('material')) {
            if ($studySession->material_path) {
                Storage::disk('public')->delete($studySession->material_path);
            }
            $path = $request->file('material')->store('study-materials', 'public');
            $validated['material_path'] = $path;
        }

        $studySession->update($validated);

        return redirect()->route('dashboard')->with('success', 'Study group updated successfully!');
    }

    public function destroy(StudyGroup $studySession)
    {
        if ($studySession->user_id !== auth()->id()) {
            abort(403);
        }

        if ($studySession->material_path) {
            Storage::disk('public')->delete($studySession->material_path);
        }

        $studySession->delete();

        return redirect()->route('dashboard')->with('success', 'Study group deleted successfully!');
    }

    public function join(Request $request, StudyGroup $studySession)
    {
        $user = auth()->user();

        if ($studySession->status === 'full' || $studySession->status === 'completed') {
            return redirect()->route('dashboard')->with('error', 'This session is not available for joining.');
        }

        if ($studySession->joined_count >= $studySession->participant_limit) {
            return redirect()->route('dashboard')->with('error', 'This session is full.');
        }

        if ($studySession->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('error', 'You have already joined this session.');
        }

        $studySession->users()->attach($user->id);
        $studySession->increment('joined_count');

        if ($studySession->joined_count >= $studySession->participant_limit) {
            $studySession->update(['status' => 'full']);
        }

        return redirect()->route('dashboard')->with('success', "You've joined {$studySession->topic}!");
    }

    public function storeHelpRequest(Request $request)
    {
        $validated = $request->validate([
            'course_code' => ['required', 'string', 'max:20'],
            'topic' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'open';
        $validated['response_count'] = 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('help-images', 'public');
            $validated['image_path'] = $path;
        }

        HelpRequest::create($validated);

        return redirect()->route('dashboard')->with('success', 'Help request posted successfully!');
    }

    public function updateHelpRequest(Request $request, HelpRequest $helpRequest)
    {
        if ($helpRequest->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'course_code' => ['required', 'string', 'max:20'],
            'topic' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'status' => ['required', 'string', 'in:open,in_progress,resolved'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            if ($helpRequest->image_path) {
                Storage::disk('public')->delete($helpRequest->image_path);
            }
            $path = $request->file('image')->store('help-images', 'public');
            $validated['image_path'] = $path;
        }

        $helpRequest->update($validated);

        return redirect()->route('dashboard')->with('success', 'Help request updated successfully!');
    }

    public function destroyHelpRequest(HelpRequest $helpRequest)
    {
        if ($helpRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if ($helpRequest->image_path) {
            Storage::disk('public')->delete($helpRequest->image_path);
        }

        $helpRequest->delete();

        return redirect()->route('dashboard')->with('success', 'Help request deleted successfully!');
    }

    public function storeAttendanceBulk(Request $request, StudyGroup $studySession)
    {
        $validated = $request->validate([
            'attendance' => ['array'],
            'matric_numbers' => ['required', 'array'],
            'matric_numbers.*' => ['required', 'string'],
        ]);

        foreach ($validated['matric_numbers'] as $matric) {
            $attended = isset($validated['attendance'][$matric]) && $validated['attendance'][$matric] == 1;

            Attendance::updateOrCreate(
                [
                    'student_matric' => $matric,
                    'study_group_id' => $studySession->id,
                ],
                [
                    'attended' => $attended,
                ]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Attendance updated successfully!');
    }

    public function storeRating(Request $request, StudyGroup $studySession)
    {
        $validated = $request->validate([
            'rating_stars' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback_text' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['study_group_id'] = $studySession->id;

        Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'study_group_id' => $studySession->id,
            ],
            $validated
        );

        return redirect()->route('dashboard')->with('success', 'Rating submitted successfully!');
    }

    public function markCompleted(Request $request, StudyGroup $studySession)
    {
        if ($studySession->user_id !== auth()->id()) {
            abort(403);
        }

        $studySession->update(['status' => 'completed']);

        return redirect()->route('dashboard')->with('success', 'Session marked as completed!');
    }

    public function showHelpRequest(HelpRequest $helpRequest)
    {
        $helpRequest->load(['user', 'responses']);

        return view('help-requests.show', [
            'helpRequest' => $helpRequest,
        ]);
    }

    public function storeHelpResponse(Request $request, HelpRequest $helpRequest)
    {
        $validated = $request->validate([
            'reply_text' => ['required', 'string', 'max:5000'],
        ]);

        $helpRequest->responses()->create([
            'student_name' => auth()->user()->name,
            'reply_text' => $validated['reply_text'],
        ]);

        $helpRequest->increment('response_count');

        if ($helpRequest->status === 'open') {
            $helpRequest->update(['status' => 'in_progress']);
        }

        return redirect()->route('help-requests.show', $helpRequest)->with('success', 'Your reply has been posted!');
    }

    public function storeChatMessage(Request $request, StudyGroup $studySession)
    {
        $user = auth()->user();

        $isHost = $studySession->user_id === $user->id;
        $isJoined = $studySession->users()->where('user_id', $user->id)->exists();

        if (!$isHost && !$isJoined) {
            return redirect()->route('dashboard')->with('error', 'You must join this session to send messages.');
        }

        $validated = $request->validate([
            'message_text' => ['required', 'string', 'max:2000'],
        ]);

        GroupChat::create([
            'study_group_id' => $studySession->id,
            'student_name' => $user->name,
            'message_text' => $validated['message_text'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Message sent!');
    }

    public function downloadMaterial(StudyGroup $studySession)
    {
        if (!Storage::disk('public')->exists($studySession->material_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($studySession->material_path);
    }
}
