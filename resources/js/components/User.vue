<template>
    <el-container>
        <el-col style="display:flex; flex-direction:column; align-items:center" >
            <h1>Lista de Usuarios</h1>
            <el-card class="box-card" style="width:80%" >
                <el-row  style="width:100%; text-align:end" >
                    <el-button @click="showAddModal = true" type="success" > Agregar Usuario </el-button>
                </el-row>
                <el-table :data="usersData">
                    <el-table-column
                        prop="title"
                        label="Nombre"
                        >
                    </el-table-column>
                    <el-table-column
                        width="200"
                        prop="id"
                        label="Id Usuario"
                        >
                    </el-table-column>
                    <el-table-column
                        label="Activo"
                        width="250">
                        <template  slot-scope="props" >
                            <div v-if="props.row.completed" >
                                <p>Si</p>
                            </div>
                            <div v-else >
                                <p>No</p>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        width="400"
                        label="Operaciones">
                        <template slot-scope="props">
                            <el-button v-show="!userToAdd.editable" @click="showEdit(props.row)" type="primary" icon="el-icon-edit" size="small">Editar</el-button>
                            <el-button @click="showDelete(props.row)" type="danger" icon="el-icon-delete" size="small">Eliminar</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-card>    
        <el-dialog title="Editar Usuario" width="25%" :visible.sync="showEditModal">
            <el-form :model="userToUpdate" size="medium" label-position="right">
                <el-row :gutter="20" >
                    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                        <el-form-item class="label-form" label="Nombre" >
                            <el-input v-model="userToUpdate.title" placeholder="Nombre del usuario" >
                            </el-input>
                        </el-form-item>
                    </el-col>    
                </el-row>    
                <el-row :gutter="20" >   
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12"> 
                        <el-form-item class="label-form" label="Activo">
                            <el-select v-model="userToUpdate.completed" placeholder="Seleccione" >
                                <el-option v-for="item in completedOptions" :key="item.value" :label="item.label" :value="item.value" > </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>    
                </el-row>    
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showEditModal = false">Cancel</el-button>
                <el-button type="primary" @click="editUser(userToUpdate)">Guardar</el-button>
            </span>
        </el-dialog>
        <!---->
        <!--ADD USER-->
        <el-dialog title="Agregar Usuario" width="25%" :visible.sync="showAddModal">
            <el-form :model="userToAdd" size="medium" label-position="right">
                <el-row :gutter="20" >
                    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                        <el-form-item class="label-form" label="Nombre" >
                            <el-input v-model="userToAdd.title" placeholder="Nombre del usuario" >
                            </el-input>
                        </el-form-item>
                    </el-col>    
                </el-row>    
                <el-row :gutter="20" >   
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12"> 
                        <el-form-item class="label-form" label="Activo">
                            <el-select v-model="userToAdd.completed" placeholder="Seleccione" >
                                <el-option v-for="item in completedOptions" :key="item.value" :label="item.label" :value="item.value" > </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>    
                </el-row>    
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showAddModal = false">Cancel</el-button>
                <el-button type="primary" @click="addUser(userToAdd)">Guardar</el-button>
            </span>
        </el-dialog>
        <!---->
        <!--DELETE USER-->
         <el-dialog
            title="Confirme"
            :visible.sync="showDeleteAlert"
            width="20%"
            >
            <div style="display:flex; align-items:center; justify-content:center" >
                <h3>¿Está seguro de eliminar a "{{deleteUserInfo.title}}" ?</h3>
            </div> 
            <el-button type="primary" @click="deleteUser(), showDeleteAlert = false" >
                Si
            </el-button>
            <el-button  type="primary" @click="showDeleteAlert = false, certificatedialogVisible = false">
                Cancelar
            </el-button>
        </el-dialog>
        <!---->
        </el-col>
        
    </el-container>    
    
</template>

<script>
import axios from "axios";
    export default {
        data() {
            return {
                usersData:this.users,
                agregated:false,
                userToUpdate:{
                    title:"",
                    completed:"",
                    id:""
                },
                userToAdd:{
                    title:"",
                    completed:"",
                    id:"",
                    userId:10,
                },
                deletedUser:false,
                deleteUserInfo:"",
                showEditModal:false,
                showAddModal:false,
                showDeleteAlert:false,
                completedOptions:[
                    {
                        value:false,
                        label:"No"
                    },
                    {
                        value:true,
                        label:"Si"
                    }
                ],
            }    
        },   
        props:['users'],
        methods:{
            getUsers(){
                axios
                    .get('/api/get-users')
                    .then(response => {
                        
                    })
                
            },
            editUser(user){
                axios
                    .put('/api/edit-user', user)
                    .then(response => {
                        var editedUsers = this.usersData.map(function(user){
                            if(user.id === response.data.json.id){
                                user.title = response.data.json.title
                                user.completed = response.data.json.completed
                            }
                        });
                        this.alertSuccess()
                    })
                this.showEditModal = false   
            },
            deleteUser(){
                var user = this.deleteUserInfo
                axios
                .post('/api/delete-user', user)
                .then(response => {                  
                    if(response.data.data = {}){
                        var newUsers = this.usersData.filter(function(user){
                            return user.id != response.data.deletedUserId 
                        });
                    }
                    this.usersData=newUsers
                    this.showDeleteAlert = false
                    this.alertSuccess()
                })
            },
            addUser(newUser){
               axios
                .post('/api/add-user', newUser)
                .then(response => {                  
                    response.data.json.id = response.data.id
                    this.usersData.unshift(response.data.json)
                    this.alertSuccess()
                })
                this.showAddModal = false   
            },
            showEdit(user){
                this.showEditModal = true;
                this.userToUpdate.title = user.title
                this.userToUpdate.completed = user.completed
                this.userToUpdate.id = user.id
            },
            showDelete(deleteUser){
                this.showDeleteAlert = true
                this.deleteUserInfo=deleteUser
            },
            alertSuccess() {
            this.$notify.success({
                title: "¡Hecho!",
                message: "",
                offset: 100
            });
            },
        },
        created() {
            this.getUsers()
            
        }
    }
</script>

<style scoped>
    .el-container{
        min-height: calc(100vh - 100px);
    }    
    .box-card{
        border-radius: 40px;
        margin: 4px;
    }

</style>