<template>
    <Layout>
    
        <Head>
            <title>About Us - Made In Tampa</title>
            <meta head-key="description" name="description" content="Companies Hiring in the Tampa Bay" />
            <!-- Open Graph / Facebook -->
            <meta property="og:type" content="website">
            <meta property="og:url" content="https://dev.madeintampabay.org/about_us">
            <meta property="og:title" content="About Us">
            <meta property="og:description" content="Companies Hiring in the Tampa Bay">
            <meta property="og:image" content="">
        </Head>
        <section data-app>
            <div class="relative max-w-6xl px-4 mx-auto sm:px-6">
                <div class="pb-12 pt-36 md:pt-40 md:pb-20">
                    <!-- Page header -->
                    <div class="max-w-3xl pb-12 mx-auto text-center md:pb-16">
                        <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Our Purpose is Simple</h1>
                    </div>
                    <div class="contentPage">
                        <p>You’re ready to land your dream job in Tampa Bay's booming tech industry. Made in Tampa makes it easy find the perfect gig.</p>
    
                        <p>Great weather, business friendly government, and a thriving start-up scene means that Tampa is quickly becoming a magnet for national and global tech companies. Job seekers need a better way to learn about Tampa Bay's tech companies
                            and startups. </p>
    
    
                        <p>
                            Made in Tampa is your go-to source for news and opportunities in Tampa's tech industry. And we're making it easier for job seekers to connect with employers.
                        </p>
    
    
                        <p>
                            Made in Tampa was created with one mission – to make navigating Tampa Bay's tech industry easier than ever before. Made in Tampa is your one-stop shop for everything you need to know about Tampa Bay's thriving tech industry. We write articles about local
                            companies, deep dive into their company culture, and curate exciting job opportunities that feature in-depth company profiles so you can easily find the perfect career. Plus, we're constantly updating our site with the latest tech
                            news, events, and opportunities so you'll never miss out.
                        </p>
    
    
                        <p>
                            Made In Tampa keeps you connected through a robust network of industry professionals and leaders:
                        </p>
    
    
                        <p>
                            <ul>
                                <li> Gain a competitive edge in the tech job market with Tampa Bay tech industry insights. </li>
                                <li>Get the inside scoop on company culture and performance.</li>
                                <li>Get access to the latest tech and startup job openings.</li>
                                <li>Connect with employers and find your dream job.</li>
                            </ul>
                        </p>
    
                        <p>
    
    
                            Join a community that celebrates the entrepreneurial spirit of Tampa Bay. Register so you can stay current with the technology community and take advanatage of exciting job opportunities as soon as they become available.
    
                        </p>
    

                        <Link v-if="is_logged_in == 0" href="/register" class="bg-purple-600 rounded-none btn-sm hover:bg-purple-700"> Register Now
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
    components: {
        Head,
        Layout,
        Footer,
        Link,
    },
    props: {
        is_logged_in: Number, 
    },
    
};
</script>
