<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Portfolio meta
    |--------------------------------------------------------------------------
    */
    'meta' => [
        'locale' => 'en-US',
        'pdf' => '/resume.pdf',
    ],

    /*
    |--------------------------------------------------------------------------
    | External services
    |--------------------------------------------------------------------------
    */
    'contact_email' => env('CONTACT_EMAIL', 'parelkirby@gmail.com'),
    'mail_service_url' => env('MAIL_SERVICE_URL', 'https://mail-service-nine.vercel.app'),
    'rag_api_url' => env('RAG_API_URL', 'https://portfolio-rag-tau.vercel.app'),

    /*
    |--------------------------------------------------------------------------
    | Tag pill color classes
    |--------------------------------------------------------------------------
    */
    'tag_colors' => [
        'React' => 'bg-blue-100 text-blue-800',
        'CSS' => 'bg-teal-100 text-teal-800',
        'CSS3' => 'bg-teal-100 text-teal-800',
        'Tailwind' => 'bg-teal-100 text-teal-800',
        'Stripe' => 'bg-purple-100 text-purple-800',
        'Design System' => 'bg-yellow-100 text-yellow-800',
        'D3' => 'bg-amber-100 text-amber-800',
        'Realtime' => 'bg-green-100 text-green-800',
        'Storybook' => 'bg-pink-100 text-pink-800',
        'NPM Package' => 'bg-red-100 text-red-800',
        'Material-UI' => 'bg-indigo-100 text-indigo-800',
        'Chatbot' => 'bg-violet-100 text-violet-800',
        'OpenAI' => 'bg-gray-100 text-gray-800',
        'Hugging Face' => 'bg-orange-100 text-orange-800',
        'Beginner' => 'bg-cyan-100 text-cyan-800',
        'Beginner Project' => 'bg-cyan-100 text-cyan-800',
        'FastAPI' => 'bg-teal-500 text-white',
        'MongoDB' => 'bg-green-600 text-white',
        'Terraform' => 'bg-purple-600 text-white',
        'IaC' => 'bg-indigo-500 text-white',
        'AWS' => 'bg-orange-500 text-white',
        'Azure' => 'bg-blue-600 text-white',
        'GCP' => 'bg-red-600 text-white',
        'Algorithms' => 'bg-blue-500 text-blue-100',
        'DSA' => 'bg-purple-300 text-purple-900',
        'ML' => 'bg-blue-200 text-blue-800',
        'AI' => 'bg-gray-200 text-gray-800',
        'AI & ML' => 'bg-amber-100 text-amber-900',
        'Visualization' => 'bg-orange-100 text-purple-900',
        'Next.js' => 'bg-black text-white',
        'Full Stack' => 'bg-gradient-to-r from-blue-500 to-purple-600 text-white',
        'Laravel' => 'bg-red-100 text-red-800',
        'PHP' => 'bg-indigo-100 text-indigo-800',
        'MySQL' => 'bg-blue-100 text-blue-800',
        'HTML/CSS' => 'bg-orange-100 text-orange-800',
        'JavaScript' => 'bg-yellow-100 text-yellow-800',
        'Capstone' => 'bg-green-100 text-green-800',
    ],

    /*
    |--------------------------------------------------------------------------
    | Simple Icons CDN slug map
    |--------------------------------------------------------------------------
    */
    'icon_slugs' => [
        'SiHtml5' => 'html5',
        'SiJavascript' => 'javascript',
        'SiReact' => 'react',
        'SiTailwindcss' => 'tailwindcss',
        'SiPhp' => 'php',
        'SiLaravel' => 'laravel',
        'SiMysql' => 'mysql',
        'SiGit' => 'git',
        'SiGithub' => 'github',
        'SiVisualstudiocode' => 'visualstudiocode',
    ],
];
