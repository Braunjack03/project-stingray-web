<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\JobPost;
use App\Models\Location;
use App\Models\CompanyProfile;
use App\Models\CompanyType;
use Inertia\Inertia;
use Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['home', 'jobs','contact','contactSubmit']]);
    }
    /**
     * Dashboard
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }

        try {
            $user = Auth::user();
            return Inertia::render('dashboard', [
                'user' => [
                    'email' => $user->email,
                    'name' => $user->email,
                    'role' => $user->role,
                    'is_email_verified' => $user->is_email_verified
                ],
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    public function home()
    {
        $job_posts = JobPost::count();
        $locations = Location::get();
        $companytypes = CompanyType::take(40)->get();
        return Inertia::render('home', ['count_job_posts' => $job_posts, 'locations' => $locations, 'companytypes' => $companytypes]);
    }

    public function jobs(Request $request)
    {

        try {
            $job_posts_query = JobPost::leftjoin('company_profiles', 'job_posts.company_profile_id', 'company_profiles.id')
                ->leftjoin('locations', 'job_posts.location_id', 'locations.id')
                ->select(
                    'job_posts.name as name',
                    'job_posts.content as content',
                    'company_profiles.name as company_name',
                    'job_posts.apply_url as apply_url',
                    'company_profiles.slug as company_slug',
                    'locations.name as location',
                    'job_posts.slug as job_slug',
                    'job_posts.created_at'
                )->when($request->q, function ($query, $term) {
                    if ($term != 'null') {
                        $query->where('job_posts.name', 'LIKE', '%' . $term . '%');
                        //$query->Orwhere('job_posts.content', 'LIKE', '%'.$term.'%');
                    }
                })->when($request->loc, function ($query, $term1) {

                    if ($term1 != 'null' && $term1 != 'NaN') {
                        $query->where('job_posts.location_id', $term1);
                    }
                })
                ->orderBy('job_posts.created_at', 'DESC');

            $job_posts_count = $job_posts_query->count();

            $job_posts = $job_posts_query->paginate($this->paginationLimit)->onEachSide(1);

            $term_u = $request->q;
            if ($term_u == 'null' || $term_u == 'NaN') {
                $term_u = '';
            }
            $locations = Location::get();
            return Inertia::render('job_posts', ['job_posts' => $job_posts, 'job_posts_count' => $job_posts_count, 'loc_id' => $request->loc, 'location_id' => $request->loc, 'term' => $term_u, 'locations' => $locations]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    public function contact()
    {
        try {
            return Inertia::render('contact');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    public function contactSubmit(Request $request)
    {
        try {
            $data = $request->all();
            Mail::send('emails.contactForm', ['data' => $data], function ($message) use ($data) {
                $message->to(env('ADMIN_EMAIL'));
                $message->subject($data['subject']);
            });

            return $this->sendSuccessResponse('contact', __('messages.contact_form_submit'), []);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }
}
