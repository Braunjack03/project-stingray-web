<template>
  <Layout>
    <Head title="For Employers" />
    <section data-app>
      <div class="relative max-w-6xl px-4 mx-auto sm:px-6">
        <div class="pb-12 pt-36 md:pt-40 md:pb-20">
          <!-- Page header -->
          <div class="max-w-3xl pb-12 mx-auto text-center md:pb-16">
            <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">
              Attract Qualified Canidates
            </h1>
          </div>
          <div class="contentPage">
<p>Recruiting the right candidate is getting tougher all of the time.  The U.S. now has more job openings than any time in history</p>

<p>The best candidates have their pick of companies to work for.</p>

<p>Candidates are becoming more sophisticated and they want to know details about a company before even talking to a recruiter.   They want to know details of not only base compensation, but bonuses, PTO, and your remote work policy.</p>

<p>The Tampa Bay job market is particularly ferocious as new companies move into the area on an almost daily basis.</p>

<p>Candidates come to you.</p>

<p>Made in Tampa makes it easy for you the employer to highlight your organization's culture and benefits.  Our rapidly evolving company profiles let you tell the story of your organization in a way that easily attract qualified candidates. </p>


<p>We have years of experience building recruiting technology</p>

<p>The team that created Made in Tampa, spent several years at one of the industries top HR technology companies building talent acquisition software.  We know how to leverage technology to save recruiters time and reduce mean time to fill.  That means you  get butts in seats faster and easier. </p>

<p>You can expect the platform to grow and evolve quickly in the coming months. </p>

<p>We have advanced capabilities on the roadmap that will use AI/ML technology to intelligently and automatically match candidates to your job reqs.</p>

<p>Our affordable subscription plans start at less than $20/mth.   That's not much more than a couple of Starbuck's coffees.   For larger organizations with advanced hiring needs we can quickly scale with you.</p>

                <Link
                href="/pricing"
                class="bg-purple-600 rounded-none btn-sm hover:bg-purple-700"
              >
               Subscribe Today 
              </Link>
          </div>
        </div>
      </div>
    </section>
  </Layout>
</template>

<script>
import Layout from "./Layout";
import { Head, Link } from "@inertiajs/inertia-vue";
import Footer from "../partials/Footer.vue";

export default {
  metaInfo: {
    title: "For Employers",
    titleTemplate: "%s - Made in Tampa",
    meta: [
      { name: "description", content: "Companies Hiring in the Tampa Bay" },
    ],
  },

  components: {
    Head,
    Layout,
    Footer,
    Link,
  },
};
</script>
