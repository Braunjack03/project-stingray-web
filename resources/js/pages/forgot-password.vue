<template>
    <Layout>
        <Head title="Forgot Password" />
        <section class="relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
    
                    <!-- Page header -->
                    <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20 text-gray-700">
                        <h1 class="h1 mb-4">Forgot your password?</h1>
                        <p class="text-xl ">We'll email you instructions on how to reset it.</p>
                    </div>
    
                    <div class="max-w-sm mx-auto">
                        <div v-if="errors.message" class="text-red-500 text-sm mt-2">{{ errors.message }}</div>
                        <div v-if="success" class="text-green-500 text-sm mt-2">{{ success.message }}</div>
                        <form class="forgot-password">
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1" for="email">Email</label>
                                    <input id="email" type="email" v-model="form.email" :rules="form.emailRules" class="form-input w-full text-gray-300" placeholder="you@yourcompany.com" required />
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mt-6">
                                <div class="w-full px-3">
                                    <button :disabled="!valid" type="button" @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Reset Password</button>
                                </div>
                            </div>
                        </form>
                        <div class="text-gray-400 text-center mt-6">
                            <Link href="/login" class="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out">Cancel</Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from './Layout'
import { Head, Link } from '@inertiajs/inertia-vue'

export default {
    components: {
        Layout,
        Head,
        Link
    },
    props: {
        errors: Object,
        success: Object,
    },
    data: () => ({
        message: '',
        valid: true,
        form: {
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
        },
    }),
    methods: {
        validate() {
            this.$refs.form.validate();
            return true;
        },
        submit() {
            this.$inertia.post('/forgot-password', this.form);
            this.form.email = '';
            this.$refs.form.resetValidation();
        },
    },
}
</script>