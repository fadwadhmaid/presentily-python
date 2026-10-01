<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * GET /api/sections
     * Liste publique des sections disponibles
     */
    public function sections()
    {
        $sections = Section::active()
            ->ordered()
            ->get(['id', 'code', 'name', 'short_name', 'description', 'color']);

        return response()->json([
            'success'  => true,
            'sections' => $sections,
        ]);
    }

    /**
     * GET /api/courses
     * Cours de la section de l'utilisateur connecté
     * (ou d'une section passée en ?section=code)
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // 1) Déterminer quelle section utiliser
        $sectionCode = $request->query('section') ?? $user->section?->code;

        if (!$sectionCode) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune section sélectionnée. Choisis ta section.',
            ], 400);
        }

        // 2) Récupérer la section
        $section = Section::where('code', $sectionCode)->first();

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Section introuvable.',
            ], 404);
        }

        // 3) Récupérer les cours actifs de cette section
        $courses = Course::forSection($section->id)
            ->active()
            ->ordered()
            ->get();

        // 4) Récupérer la progression de l'utilisateur sur ces cours
        $userCourses = $user->courses()
            ->whereIn('courses.id', $courses->pluck('id'))
            ->get()
            ->keyBy('id');

        // 5) Fusionner cours + progression
        $courses = $courses->map(function ($course) use ($userCourses) {
            $userCourse = $userCourses->get($course->id);

            return [
                'id'             => $course->id,
                'number'         => $course->number,
                'title'          => $course->title,
                'description'    => $course->description,
                'category'       => $course->category,
                'category_color' => $course->category_color,
                'duration'       => $course->duration,
                'lessons'        => $course->lessons,
                'xp_reward'      => $course->xp_reward,
                'progress'       => $userCourse?->pivot->progress ?? 0,
                'status'         => $userCourse?->pivot->status ?? 'not_started',
            ];
        });

        return response()->json([
            'success' => true,
            'section' => [
                'id'         => $section->id,
                'code'       => $section->code,
                'name'       => $section->name,
                'short_name' => $section->short_name,
                'color'      => $section->color,
            ],
            'courses' => $courses,
        ]);
    }

    /**
     * GET /api/courses/{course}
     * Détail d'un cours
     */
    public function show(Request $request, Course $course)
    {
        $user = $request->user();

        // Charger la section
        $course->load('section');

        // Récupérer la progression de l'utilisateur
        $userCourse = $user->courses()
            ->where('course_id', $course->id)
            ->first();

        return response()->json([
            'success' => true,
            'course' => [
                'id'             => $course->id,
                'number'         => $course->number,
                'title'          => $course->title,
                'description'    => $course->description,
                'category'       => $course->category,
                'category_color' => $course->category_color,
                'duration'       => $course->duration,
                'lessons'        => $course->lessons,
                'xp_reward'      => $course->xp_reward,
                'progress'       => $userCourse?->pivot->progress ?? 0,
                'status'         => $userCourse?->pivot->status ?? 'not_started',
                'section' => [
                    'id'   => $course->section->id,
                    'code' => $course->section->code,
                    'name' => $course->section->name,
                ],
            ],
        ]);
    }

    /**
     * POST /api/user/section
     * Change la section de l'utilisateur connecté
     */
    public function setSection(Request $request)
    {
        $validated = $request->validate([
            'section_code' => 'required|string|exists:sections,code',
        ]);

        $section = Section::where('code', $validated['section_code'])->first();

        $user = $request->user();
        $user->section_id = $section->id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Section mise à jour avec succès.',
            'section' => [
                'id'   => $section->id,
                'code' => $section->code,
                'name' => $section->name,
            ],
        ]);
    }

    /**
     * PUT /api/courses/{course}/progress
     * Met à jour la progression sur un cours
     */
    public function updateProgress(Request $request, Course $course)
    {
        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $user = $request->user();
        $progress = $validated['progress'];

        // Déterminer le statut
        $status = 'in_progress';
        if ($progress >= 100) {
            $status = 'completed';
        } elseif ($progress === 0) {
            $status = 'not_started';
        }

        // Insérer ou mettre à jour la ligne dans user_courses
        $user->courses()->syncWithoutDetaching([
            $course->id => [
                'progress'     => $progress,
                'status'       => $status,
                'started_at'   => $status !== 'not_started' ? now() : null,
                'completed_at' => $status === 'completed' ? now() : null,
            ],
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Progression mise à jour.',
            'progress' => $progress,
            'status'   => $status,
        ]);
    }
}