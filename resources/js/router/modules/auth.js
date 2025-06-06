import AuthLayout from "@/components/Layouts/AuthLayout.vue";

export default [
    {
        path: "/auth",
        component: AuthLayout,
        meta: { requiresGuest: true },
        children: [
            {
                path: "",
                redirect: { name: "Login" }
            },
            {
                path: "login",
                name: "Login",
                component: () => import("@/views/Auth/LoginView.vue"),
                meta: { title: "Iniciar Sesión" },
            },
            {
                path: "forgot-password",
                name: "ForgotPassword",
                component: () => import("@/views/Auth/ForgotPassword.vue"),
                meta: { title: "Recuperar Contraseña" },
            },
        ],
    },
];
