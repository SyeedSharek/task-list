<template>
    <div class="container-fluid">
        <div class="row p-0">
            <div class="col-2 sidebar p-0">
                <h4>Admin Dashboard</h4>
                <div
                    v-for="checkRole in roleWiserPermissions"
                    :key="checkRole.id"
                    class="list-group list-group-flush text-bold"
                >
                  
                    <router-link
                    
                    v-if="checkRole.name === 'product list'"
                        :to="{ name: 'ProductList' }"
                        class="list-group-item list-group-item-action list-group-item-dark "
                        active-class="active"                      

                    >Product List</router-link>

                    <router-link
                    
                    v-if="checkRole.name === 'top order list'"
                        :to="{ name: 'TopOrder' }"
                        class="list-group-item list-group-item-action list-group-item-dark "
                        active-class="active"                      

                    >Top Order List</router-link>
                    <router-link                   
                    
                    v-if="checkRole.name === 'top product list'"
                        :to="{ name: 'TopSellProduct' }"
                        class="list-group-item list-group-item-action list-group-item-dark "
                                             

                    >Top Product List</router-link>
                    <a
                        v-if="checkRole.name === 'dashboard'"
                        href="#"
                        class="list-group-item list-group-item-action list-group-item-dark"
                        >Dashboard</a
                    >

                    <router-link
                        v-if="checkRole.name === 'permission list'"
                        :to="{ name: 'PermissionList' }"
                        class="list-group-item list-group-item-action list-group-item-dark"
                       
                        >Permission List</router-link
                    >

                    <router-link
                        v-if="checkRole.name === 'user list'"
                        :to="{ name: 'ListUserRole' }"
                        class="list-group-item list-group-item-action list-group-item-dark"
                        
                        >User List</router-link
                    >
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-10 main-contain m-0 p-0">
                <nav class="navbar bg-body-tertiary">
                    <div class="container-fluid">
                        <a href="#" class="navbar-brand"
                            >Product Management Project</a
                        >

                        <button
                            @click.prevent="logout"
                            class="btn btn-outline-success"
                            type="submit"
                        >
                            Logout
                        </button>
                    </div>
                </nav>

                <div class="main-view">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            message: "Welcome to the Desh Board!",
            roleWiserPermissions: [],
            products: [],
        };
    },
    mounted() {
        this.productList();
        this.RoleWisePermission();
    },
    methods: {
        logout() {
            const token = localStorage.getItem("authToken");

            axios
                .post(
                    "/api/auth/logout",
                    {},

                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                )
                .then(() => {
                    localStorage.removeItem("authToken");
                    this.$router.push({ name: "Login" });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        productList() {
            const token = localStorage.getItem("authToken");
            if (token) {
                axios
                    .get("/api/auth/product/products", {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((response) => {
                        console.log(response);
                        this.products = response.data.data.products || [];
                    })
                    .catch((error) => {
                        console.log("Data Error", error);
                    });
            } else {
                this.$router.push({ name: "Login" });
                return;
            }
        },
        RoleWisePermission() {
            const token = localStorage.getItem("authToken");
            if (token) {
                axios
                    .get("/api/auth/user/rolewisepermission", {
                        headers: { Authorization: `Bearer ${token}` },
                    })
                    .then((response) => {
                        console.log(response.data);
                        this.roleWiserPermissions = response.data.permissions;
                    })
                    .catch((error) => {
                        console.error("Error fetching permissions", error);
                    });
            }
        },
    },
};
</script>
<style>
html,
body {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden;
}
.sidebar {
    height: 100vh;
    background: none;
    background-color: #777;
    overflow-y: auto;
}
.list-group-item {
    background-color: transparent;
    color: #ddd;
}
.logout-btn {
    margin-left: auto;
}
.main-contain {
    height: 100vh;
    overflow-y: auto;
}
</style>
