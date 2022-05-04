<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-700">
        <div>
            <slot name="logo" />
            
        </div>
        <div class="w-full sm:max-w-md mt-3 px-6 py-4 overflow-hidden">
            <h2 class="text-center text-2xl font-extrabold text-white" antialiased> {{ $page.props.appName }} </h2>
        </div>
        <div class="w-full sm:max-w-md mt-3 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
        <div class="w-full sm:max-w-md mt-3 px-6 py-4 text-center bg-white shadow-md overflow-hidden sm:rounded-lg">
            <i class="text-gray-700"><strong>Data </strong>: {{ $page.props.userInfo.data }} - <strong>Version </strong>: {{ $page.props.userInfo.version }}</i>
            <br>
            <i class="text-gray-700"><strong>IP </strong>: {{ $page.props.userInfo.ip }} - <strong>Hostname </strong>: {{ $page.props.userInfo.hostname }}</i>
            <br>
        </div>
    </div>
</template>