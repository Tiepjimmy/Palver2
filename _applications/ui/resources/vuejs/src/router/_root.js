import { middleware } from "vue-router-middleware";

export default [
  ...middleware(
    [
       'auth',
      // 'config'
    ],
    [
      {
        path: "",
        component: () => import("@/theme/layout/Layout"),
        children: [],
      },
    ]
  ),
  {
    name: "login",
    path: "/login",
    component: () => import("@/components/main/pages/auth/Login"),
  },
  {
    path: "*",
    redirect: "/error-404",
  },
];
