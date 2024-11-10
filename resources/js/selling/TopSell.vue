<template>
    <div class="card">
        
        <div class="card-body">
            <h1>Top Selling Product</h1>
            <div class="input-group mb-3" style="width: 250px; float: right">
                <span class="input-group-text" id="basic-addon1"
                    ><i class="fas fa-search"></i
                ></span>
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
            <table class="table overflow-auto">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Total Sold</th>                        
                      
                    </tr>
                </thead>
                <tbody>
                    <tr
                        style="height: 80px"
                        v-for="(t_product, index) in topProducts"
                        :key="t_product.id"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ t_product.name }}</td>
                        <td>{{ t_product.sold_count }}</td>

                        
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
            topProducts: [],
            searchQuery: "",
        };
    },
    mounted() {
        this.top_products();
    },
    methods: {
        top_products() {
            const token = localStorage.getItem("authToken");
            if (token) {
                axios
                    .get("/api/auth/product/topSellingProduct", {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((response) => {
                        console.log(response);
                        this.topProducts = response.data.data.top_products;_
                        // this.tasks = response.data.tasks;
                    })
                    .catch((error) => {
                        console.log("Data Error", error);
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
       
    },
};
</script>

<style>
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
