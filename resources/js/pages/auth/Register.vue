<script setup lang="ts">
    import InputError from '@/components/InputError.vue';
    import TextLink from '@/components/TextLink.vue';
    import {Button} from '@/components/ui/button';
    import {Input} from '@/components/ui/input';
    import {Label} from '@/components/ui/label';
    import AuthBase from '@/layouts/AuthLayout.vue';
    import {Head,useForm} from '@inertiajs/vue3';
    import {LoaderCircle} from 'lucide-vue-next';
    import {ref,watch} from 'vue';
    import axios from 'axios';

    const usernameAvailable = ref(null)
    const usernameSuggestions = ref([])

    const form = useForm({
        name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    watch(() => form.username, async (newUsername) => {
        usernameAvailable.value = null
        usernameSuggestions.value = []

        if (!newUsername || newUsername.length < 3) return

        try {
            const res = await axios.get('/check-username', {
                params: {
                    username: newUsername
                }
            })

            usernameAvailable.value = res.data.available
            if (!res.data.available) {
                usernameSuggestions.value = res.data.suggestions
            }
        } catch (e) {
            console.error('Error checking username', e)
        }
    })



    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">

        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                        v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="username">Username</Label>
                    <Input id="username" type="text" required :tabindex="1" autocomplete="username"
                        v-model="form.username" placeholder="Username" />
                    <InputError :message="form.errors.username" />

                    <p v-if="form.username && usernameAvailable === true" class="text-sm text-green-600">✅ Username <strong>{{ form.username }}</strong> is
                        available</p>
                    <p v-if="form.username && usernameAvailable === false" class="text-sm text-red-600">❌ Username <strong>{{ form.username }}</strong> is
                        taken</p>

                    <div v-if="usernameSuggestions.length > 0" class="text-sm text-gray-500">
                        <p>Suggestions:</p>
                        <ul class="flex flex-wrap gap-2 mt-1">
                            <li v-for="(s, index) in usernameSuggestions" :key="index"
                                class="cursor-pointer text-blue-500 hover:underline" @click="form.username = s"><Button variant="outline">
                                {{ s }}</Button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required :tabindex="2" autocomplete="email"
                        v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" required :tabindex="3" autocomplete="new-password"
                        v-model="form.password" placeholder="Password" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input id="password_confirmation" type="password" required :tabindex="4"
                        autocomplete="new-password" v-model="form.password_confirmation"
                        placeholder="Confirm password" />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
