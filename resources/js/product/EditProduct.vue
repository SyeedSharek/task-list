<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h2>Update Task</h2>
                    </div>
                    <div class="card-body">
                        <form
                            @submit.prevent="updateData"
                            enctype="multipart/form-data"
                        >
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="formData.name"
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
                                />
                                <span
                                    class="text-danger"
                                    v-for="(
                                        error, index
                                    ) in formError.description"
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

export default {
    data() {
        return {
            formData: {
                name: "",
                description: "",
                price:"",
                stock:"",
               
            },
            formError: {
                name: [],
                description: [],
                price:[],
                stock:[],
            },
     
        };
    },
    mounted() {
        this.edit();
    },
    methods: {
        edit() {
            const token = localStorage.getItem("authToken");
            if (token) {
                axios
                    .get("/api/auth/product/show/" + this.$route.params.id, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((response) => {
                                           
                            this.formData = response.data.data.products;                        
                    })
                    .catch((error) => {
                        console.error("Error fetching product data:", error);
                        this.formData = {
                            name: "",
                            description: "",
                            price: "",
                            stock: "",
                            
                        };
                    });
            }
        },
      
        updateData() {
            const token = localStorage.getItem("authToken");
            if (token) {               

                axios
                    .post(
                        `/api/auth/product/update/${this.$route.params.id}`,
                        this.formData,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                                "Content-Type": "multipart/form-data",
                            },
                        }
                    )
                    .then((response) => {
                        this.$router.push({ name: "ProductList" });
                    })
                    .catch((error) => {
                        console.log(error.response.data);
                    });
            }
        },
    },
};
</script>
