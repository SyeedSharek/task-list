import { createRouter, createWebHashHistory } from "vue-router";
import Login from "./../login/Login.vue";
import Register from "./../login/Register.vue";
import Dashboard from "./../deshboard/Dashboard.vue";
import PermissionList from "./../permission/PermissionList.vue";
import PermissionCreate from "./../permission/PermissionCreate.vue";
import PermissionEdit from "./../permission/PermissionEdit.vue";
import ListUserRole from "./../user/listUserRole.vue";
import ProductList from "../product/ProductList.vue";
import ProductAdd from "../product/AddProduct.vue";
import ProductEdit from "../product/EditProduct.vue";
import TopSellProduct from "../selling/TopSell.vue";
import TopOrder from "../selling/TopOrder.vue"

const routes = [
    {
        path: "/",
        name: "Login",
        component: Login,
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        children: [
            
            
            // Permission
            {
                path: "/permissionList",
                name: "PermissionList",
                component: PermissionList,
            },
            {
                path: "/permissionCreate",
                name: "PermissionCreate",
                component: PermissionCreate,
            },
            {
                path: "/permissionEdit/:id",
                name: "PermissionEdit",
                component: PermissionEdit,
            },
            {
                path: "/listUserRole",
                name: "ListUserRole",
                component: ListUserRole,
            },

            // Product Data

            {
                path: "/products",
                name: "ProductList",
                component: ProductList,
            },

            {
                path: "/productAdd",
                name: "ProductAdd",
                component: ProductAdd,
            },

            {
                path: "/edit/:id",
                name: "ProductEdit",
                component: ProductEdit,
            },

            {
                path: "/topSellingProduct",
                name: "TopSellProduct",
                component: TopSellProduct,
            },
            {
                path: "/topOrderList",
                name: "TopOrder",
                component: TopOrder,
            },
            
        ],
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});
export default router;
