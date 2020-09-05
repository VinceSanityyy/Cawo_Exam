<template>
    <div class="container">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add Movie
        </button>
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Release Date</th>
                <th scope="col">Duration</th>
                <th scope="col">Genre</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="movie in movies" :key="movie.id">
                <th>{{movie.id}}</th>
                <td>{{movie.title}}</td>
                <td>{{movie.release_date}}</td>
                <td>{{movie.duration}}</td>
                <td>{{movie.genre}}</td>
                <td>
                    <a href="#"  data-toggle="modal" data-target="#exampleModal" @click="editModal(movie)">
                       <button class="btn btn-warning">Update</button>
                    </a>
                    <a href="#" @click="deleteMovie(movie.id)">
                        <button class="btn btn-danger">Delete</button>
                    </a>
                </td>
              </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent ="editMode ? updateMovie() : submitMovie()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="title">
                        <label>Release Date</label>
                        <input type="text" class="form-control" v-model="release_date">
                        <label>Duration</label>
                        <input type="text" class="form-control" v-model="duration">
                        <label>Genre</label>
                        <input type="text" class="form-control" v-model="genre">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-primary">Submit</button>
                </div>
                   </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                movies:[],
                id:'',
                title:'',
                release_date:'',
                duration:'',
                genre:'',
                editMode:false
            }
        },
        methods:{
            getMovies(){
                axios.get('/movies').then((res)=>{
                    this.movies = res.data
                })
            },
            submitMovie(){
                axios.post('movie',{
                    title: this.title,
                    release_date: this.release_date,
                    duration: this.duration,
                    genre: this.genre
                }).then((res)=>{
                    alert('Ok')
                    $('#exampleModal').modal('hide')
                    this.getMovies()
                })
            },
            editModal(movie){
               this.editMode = true
               this.id = movie.id
               this.title = movie.title
               this.release_date = movie.release_date
               this.genre = movie.genre
               this.duration = movie.duration
               $('#exampleModal').modal('show')
            },
            updateMovie(){
                axios.put('/updateMovie/?id='+this.id,{
                    title: this.title,
                    release_date: this.release_date,
                    duration: this.duration,
                    genre: this.genre
                }).then((res)=>{
                    alert('Updated')
                    $('#exampleModal').modal('hide')
                    this.getMovies()
                    this.clearValues()
                })
            },
            deleteMovie(id){
                console.log(id)
                axios.delete('/deleteMovie/?id='+id).then((res)=>{
                    console.log(res)
                    alert('Deleted!')
                    this.getMovies()
                })
            },
            clearValues(){
               this.id = ''
               this.title =''
               this.release_date = ''
               this.genre = ''
               this.duration = ''
            }
        },
        created() {
            this.getMovies()
        }
    }
</script>
