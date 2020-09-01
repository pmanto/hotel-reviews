import Vue from "vue";
import VueRouter from "vue-router";
import DashboardView from "../views/DashboardView";

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    { path: "/dashboard", component: DashboardView },
    { path: "*", redirect: "/dashboard" }
  ]
});