<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <main class="min-h-screen">
        <header>
            <Link href="/public">Home</Link>
            <Link href="/about">About</Link>
            <Link href="/contact">Contact</Link>
        </header>
        <article>
            <slot />
        </article>
    </main>
</template>
