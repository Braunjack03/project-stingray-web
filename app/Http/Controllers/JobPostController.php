<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\JobPost;
use App\Models\JobCat;
use App\Models\Location;
use App\Models\CompanyProfile;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use App\Models\ActivityLog;
use Redirect;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['showJobPost']]);
    }

    /**
     * Get Job Posts
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }

        try {
            $user = Auth::user();
            $companies = CompanyProfile::where('uuid', $request->all()['c_id']);
            //get plan id
            $planId = Subscription::where(['user_id'=>$user->id])->first();
            $getPlanName = [];
            if(!empty($planId)){
                $getPlanName = getPlanName($planId['stripe_plan']);
            }
            $job_posts = JobPost::select('locations.name as location_id', 'job_posts.created_at as created_on', 'job_posts.name', 'job_posts.uuid')->join('locations', 'job_posts.location_id', '=', 'locations.id')->where('job_posts.company_profile_id', $companies->first()['id'])->orderBy('job_posts.id', 'DESC')->get()->toArray();
            $job_posts_count = JobPost::where('company_profile_id', $companies->first()['id'])->count();

            $companies = CompanyProfile::where('uuid', $request->all()['c_id']);
            //dd($job_posts);
            $response = ['status' => $this->successStatus, 'message' => '', 'responseCode' => $this->successResponse];
            $respones_array = [
                'success' => $response,
                'companies_count' => $companies->count(),
                'plan_name' => $getPlanName,
                'job_posts_count' => $job_posts_count,
                'company_details' => $companies->first(),
                'job_posts' => json_decode(json_encode($job_posts), true),
            ];

            return $this->sendResponseWithData('employer/job_posts', '', $respones_array);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    /**
     * Get Profile
     *
     * @return \Illuminate\View\View
     */

    public function create(Request $request)
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }
        try {
            $user = Auth::user();
            $job_categories = JobCat::get();
            $locations = Location::orderBy('id', 'desc')->get();

            $uuid = $request->all()['c_id'];

            return Inertia::render('employer/create-job', ['job_categories' => $job_categories, 'locations' => $locations, 'company_uuid' => $uuid]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    /**
     * To register company profile
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }
        $user_id = Auth::id();
        $job_uuid = Str::uuid();

        $request->request->add(['user_id' => $user_id, 'uuid' => $job_uuid]);

        $data = $request->all();
        $data['remotetype_id'] = 1;
        if ($data['location_id'] != 8) {
            $data['remotetype_id'] = 3;
        }

        $company_id = $data['c_id'];
        $company_profile = 0;
        $company_profile = CompanyProfile::where('uuid', $company_id)->first();
        if ($company_profile) {
            $data['company_profile_id'] = $company_profile['id'];
        }

        $redirect_page = 'employer/create-job';

        $messages = [
            'name.required' => 'Job Title is required',
            'job_cat_id.required' => 'The Job Category field is required.',
            'apply_url.required' => 'The Job Application URL field is required.',
        ];

        $validator = Validator::make($data, [
            'name' => 'required',
            'location_id' => 'required',
            'job_cat_id' => 'required',
            'apply_url' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $job_categories = JobCat::get();
            $locations = Location::get();
            $data = ['user' => $data, 'job_categories' => $job_categories, 'locations' => $locations];
            return $this->sendJobValidationErrorsWithData($redirect_page, $validator->errors(), $data);
        } else {
            try {
                unset($data['c_id']);
                $data['slug'] = $this->createJobPostSlug($data['name']);
                JobPost::create($data);

                ActivityLog::addToLog(__('activitylogs.job_created'), 'job created');
                return redirect('employer/jobs?c_id=' . $company_id)->with(['message' => __('messages.job_created')]);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page, $message);
            }
        }
    }

    /**
     * Edit Job
     *
     * @return \Illuminate\View\View
     */

    public function edit(Request $request)
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }

        try {
            $job_data = JobPost::where('uuid', $request->all()['id'])->first();
            $job_data->remotetype_id = ($job_data->remotetype_id == 1) ? true : false;
            $job_categories = JobCat::get();
            $locations = Location::get();
            return Inertia::render('employer/edit-job', ['user' => $job_data, 'job_categories' => $job_categories, 'locations' => $locations]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    /**
     * To register company profile
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }

        $job_uuid = $request->all()['id'];


        $data = $request->only(['name', 'content', 'apply_url', 'location_id', 'job_cat_id', 'remotetype_id']);

        if (isset($data['remotetype_id']) && $data['remotetype_id'] == 0) {
            $data['remotetype_id'] = 3;
        }
        $redirect_page = 'employer/edit-job';

        $messages = [
            'name.required' => 'Job Title is required',
            'job_cat_id.required' => 'The Job Category field is required.',
            'apply_url.required' => 'The Job Application URL field is required.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location_id' => 'required',
            'job_cat_id' => 'required',
            'apply_url' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $job_categories = JobCat::get();
            $locations = Location::get();
            $data = ['user' => $request->all(), 'job_categories' => $job_categories, 'locations' => $locations];
            return $this->sendJobValidationErrorsWithData($redirect_page, $validator->errors(), $data);
        } else {
            try {
                $job = JobPost::where('uuid', $job_uuid);
                $data['slug'] = $this->createJobPostSlug($data['name']);
                $job->update($data);
                $job_data = JobPost::where('uuid', $job_uuid)->first();
                $company_profile_id = CompanyProfile::select('uuid')->where('id', $job_data->company_profile_id)->first()['uuid'];

                ActivityLog::addToLog(__('activitylogs.job_updated'), 'job updated');
                return redirect('employer/jobs?c_id=' . $company_profile_id)->with(['message' => __('messages.job_updated')]);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse('employer/jobs', $message);
            }
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->all()['id'];
            $job_data = JobPost::where('uuid', $id);

            $company_profile_id = CompanyProfile::where('id', $job_data->first()['company_profile_id'])->first()['uuid'];

            $job_data->delete();
            ActivityLog::addToLog(__('activitylogs.job_deleted'), 'job deleted');

            return redirect('employer/jobs?c_id=' . $company_profile_id)->with(['message' => __('messages.job_delete')]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('employer/jobs', $message);
        }
    }

        

    public function showJobPost($company = '', $slug = '')
    {

        try {
            $job_post = JobPost::leftjoin('company_profiles', 'job_posts.company_profile_id', 'company_profiles.id')
                ->leftjoin('locations', 'job_posts.location_id', 'locations.id')
                ->select(
                    'job_posts.name as name',
                    'job_posts.content as content',
                    'company_profiles.name as company_name',
                    'company_profiles.slug as company_slug',
                    'locations.name as location',
                    'job_posts.created_at',
                    'job_posts.apply_url'
                )->where('job_posts.slug', $slug)->first();
              
            if($job_post != null && $job_post != '')
            {
                return Inertia::render('single-job-post', ['data' => $job_post]);
            }else{
                return $this->sendErrorResponse('404','');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404', $message);
        }
    }

    public function createJobPostSlug($title)
    {
        // Normalize the title
        $slug = Str::slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
    }

    protected function getRelatedSlugs($slug)
    {
        return JobPost::select('slug')->where('slug', 'like', $slug . '%')->get();
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
                    //echo $term;
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

            //dd($job_posts);
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
}
