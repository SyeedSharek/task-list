<template>
    <div class="card">
        
        <div class="card-body">
            <h1>Top Recent Order</h1>
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
                        <th scope="col">Customer Name</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Total Order</th>                        
                      
                    </tr>
                </thead>
                <tbody>
                    <tr
                        style="height: 80px"
                        v-for="(t_order, index) in recentOrders"
                        :key="t_order.id"
                    >
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ t_order.customer.name}}</td>
                        <td>{{t_order.product.name}}</td>
                        <td>{{t_order.quantity}}</td>

                        

                        
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
            recentOrders: [],
            searchQuery: "",
        };
    },
    mounted() {
        this.top_recent_order() 
            
    },
    methods: {
        top_recent_order() {
            const token = localStorage.getItem("authToken");
            if (token) {
                axios
                    .get("/api/auth/product/topOrderList", {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((response) => {
                        console.log(response);
                        this.recentOrders = response.data.data.top_orders;
;
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
