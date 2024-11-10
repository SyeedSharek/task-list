<template>
    <div class="card">
        <div class="card-body">
            <h1>Product List</h1>

         
                <div
                    class="input-group mb-0"
                    style="width: 250px; float: right"
                >
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search Here"
                        aria-label="Search"
                        aria-describedby="basic-addon1"
                        v-model="searchQuery"
                        @keyup="search"
                    />
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Check for 'product add' permission -->
                    <router-link
                       
                        v-if="hasPermission('product add')"
                        :to="{ name: 'ProductAdd' }"
                        class="btn btn-primary"
                    >
                        Add Product
                    </router-link>
                </div>
                <table class="table overflow-auto">
                    <thead>
                        <tr style="height: 150px">
                            <th style="width: 50px">SL</th>
                            <th style="width: 150px">Name</th>
                            <th style="width: auto">Description</th>
                            <th style="width: 100px">Price</th>
                            <th style="width: 100px">Stock</th>
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(product, index) in products"
                            :key="product.id"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.stock }}</td>
                            <td>
                                <!-- Check if user has 'edit product' permission -->
                                <router-link
                                    v-if="hasPermission('edit product')"
                                    :to="{
                                        name: 'ProductEdit',
                                        params: { id: product.id },
                                    }"
                                    class="btn btn-primary m-1"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </router-link>

                                <!-- Check if user has 'delete product' permission -->
                                <a
                                    
                                     v-if="hasPermission('delete product')"
                                    @click="destroy(product.id)"
                                    class="btn btn-danger"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
      
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { showToast } from "../showToast";

export default {
    data() {
        return {
            products: [],
            searchQuery: "",
            roleWiserPermissions: [],
        };
    },
    mounted() {
        this.productList();
        this.RoleWisePermission();
    },

    methods: {
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

        destroy(product_id) {
            const token = localStorage.getItem("authToken");
            if (token) {
                axios
                    .delete(`/api/auth/product/delete/${product_id}`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then(() => {
                        this.productList();
                        showToast("Delete Successfully", "success");
                    })
                    .catch((error) => {
                        console.log("Data Error");
                        showToast(`Error: ${error.message}`, "error");
                    });
            } else {
                this.$router.push({ name: "Login" });
                return;
            }
        },

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

        search() {
            const token = localStorage.getItem("authToken");
            const value = this.searchQuery;
            if (token) {
                axios
                    .get(`/api/auth/task/search?search=${value}`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((response) => {
                        this.tasks = response.data.task;
                    })
                    .catch((error) => {
                        console.log(
                            "Search error:",
                            error.response ? error.response.data : error.message
                        );
                        this.tasks = [];
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
                        this.roleWiserPermissions =
                            response.data.permissions || [];
                        console.log(
                            "Loaded permissions:",
                            this.roleWiserPermissions
                        );

                        // Optionally, extract role from response if included
                        this.currentUserRole =
                            response.data.role || this.currentUserRole;
                    })
                    .catch((error) => {
                        console.error("Error fetching permissions", error);
                    });
            }
        },

        hasPermission(permissionName) {
            return this.roleWiserPermissions.some(
                (permission) => permission.name.trim() === permissionName.trim()
            );
            
         
        },
    },
};
</script>

<style scoped>
.table-wrapper {
    max-height: 300px; /* Adjust height as needed */
    overflow-y: auto;
    overflow-x: hidden; /* Prevent horizontal scrollbar */
}

.table {
    width: 100%;
    margin-bottom: 0; /* Ensure no margin is affecting the height */
}
</style>
