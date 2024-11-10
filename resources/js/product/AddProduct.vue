<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <router-link
                            :to="{ name: 'ProductList' }"
                            class="btn btn-primary"
                            >List Product</router-link
                        >
                    </div>
                    <div class="card-body">
                        <form
                            @submit.prevent="storeData"
                            enctype="multipart/form-data"
                        >
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="formData.name"
                                    required
                                />
                                <span
                                    class="text-danger"
                                    v-for="(error, index) in formError.name"
                                    :key="index"
                                    >{{ error }}</span
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="formData.description"
                                    required
                                />
                                <span
                                    class="text-danger"
                                    v-for="(error, index) in formError.description"
                                    :key="index"
                                    >{{ error }}</span
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="formData.price"
                                    required
                                />
                                <span
                                    class="text-danger"
                                    v-for="(
                                        error, index
                                    ) in formError.price"
                                    :key="index"
                                    >{{ error }}</span
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="formData.stock"
                                    required
                                />
                                <span
                                    class="text-danger"
                                    v-for="(
                                        error, index
                                    ) in formError.stock"
                                    :key="index"
                                    >{{ error }}</span
                                >
                            </div>

                            

                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { showToast } from "../showToast";

export default {
    data() {
        return {
            formData: {
                name: "",
                description: "",
                price: "",
                stock: "",
              
            },
            formError: {
                name: [],
                description: [],
                price: [],
                stock: [],
                
            },
            
        };
    },

    mounted() {
      
    },
    methods: {       
        

        storeData() {
    const token = localStorage.getItem("authToken");

    if (token) {
        // Sending formData as the request body
        axios
            .post("/api/auth/product/productAdd", this.formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "multipart/form-data", // Ensure the content type is multipart for form data
                },
            })
            .then((response) => {
                console.log(response);
                this.$router.push({ name: "ProductList" });
                showToast("Product Add Successfully", "success");
            })
            .catch((error) => {
                console.log(error.response.data);
                showToast("Error adding product", "error");
            });
    } else {
        this.$router.push({ name: "Login" });
        return;
    }
}

    },
};
</script>

<style>

.custom-scroll {
    max-height: 150px; 
    overflow-y: auto; 
}
</style>
