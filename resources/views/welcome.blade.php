<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Laravel Api Documentation</title>
</head>

<body>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form name="editForm" id="editModal">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <h6>Title</h6>
                            <input type="text" name="title" class="form-control">
                            <span id="titleError" class="text-danger"></span>
                        </div>
                        <div class="form-group mb-3">
                            <h6>Description</h6>
                            <textarea name="description" id="" class="form-control"></textarea>
                            <span id="descError" class="text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 100px;">
        <h1 class="text-center mb-5">Laravel Api Crud</h1>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered table-striped p-3">
                    <h3>Posts</h3>
                    <div id="successMsg"></div>
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="result">

                    </tbody>
                </table>
            </div>
            <div class="col-md-4">

                <form name="createForm">
                    <h3>Create Post</h3>

                    <div id="alertMsg"></div>
                    <div class="form-group mb-3">
                        <h6>Title</h6>
                        <input type="text" name="title" class="form-control">
                        <span id="titleError" class="text-danger"></span>
                    </div>
                    <div class="form-group mb-3">
                        <h6>Description</h6>
                        <textarea name="description" id="" class="form-control"></textarea>
                        <span id="descError" class="text-danger"></span>
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <script>
        //read 
        let result = document.getElementById('result');
        axios.get('/api/posts').then(response => {

                result.innerHTML = response.data.map(item => `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.title}</td>
                        <td>${item.description}</td>
                        <td>
                           <div class="btn-group">
                               <button type="button" class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="editBtn(${item.id})">
                               Edit
                                                    </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBtn(${item.id})">Dlete</button>
                           </div> 
                        </td>
                    </tr>
    `).join('');
            }


        ).catch(error => {

            // console.log(error.response.status);

            if (error.response.status == 404) {
                console.log(error.response.config.url + " url is not found");
            }
        });

        //create
        let dataForm = document.forms['createForm'];
        let titleInput = dataForm['title'];
        let descInput = dataForm['description'];


        dataForm.onsubmit = (e) => {
            e.preventDefault();

            axios.post('/api/posts', {
                    title: titleInput.value,
                    description: descInput.value,
                })
                .then(response => {

                    let item = response.data[0];
                    result.innerHTML += `<tr>
                        <td>${item.id}</td>
                        <td>${item.title}</td>
                        <td>${item.description}</td>
                        <td>
                           <div class="btn-group">
                               <button type="button" class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="editBtn(${item.id})">
                               Edit
                                                    </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBtn(${item.id})">Dlete</button>
                           </div> 
                        </td>
                    </tr>`.join('');
                    console.log(item);
                    document.getElementById('alertMsg').innerHTML =
                        `<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>${response.data.msg}</strong> .<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`;
                    createForm.reset();


                })
                .catch(error => {

                        // console.log(error.response.data.msg.title);
                        // console.log(error.response.data.msg.description);


                        if (titleInput.value == "") {
                            document.getElementById('titleError').innerHTML = '<i>' + error.response.data.msg.title +
                                '</i>';
                        } else {
                            document.getElementById('titleError').innerHTML = '';
                        }

                        if (descInput.value == "") {
                            document.getElementById('descError').innerHTML = '<i>' + error.response.data.msg
                                .description + '</i>';
                        } else {
                            document.getElementById('descError').innerHTML = '';
                        }


                    }


                )
        }

        //edit & update
        let editform = document.forms['editForm'];
        let editTitle = editForm['title'];
        let editDesc = editForm['description'];
        let postIdToUpdate;

        function editBtn(postId) {
            postIdToUpdate = postId;
            axios.get(`api/posts/${postId}`)
                .then(response => {
                    editTitle.value = response.data.title;
                    editDesc.value = response.data.description;
                })
                .catch(error => {
                    cosole.log(error)
                })
        }

        editform.onsubmit = (e) => {
            e.preventDefault();
            // console.log(postIdToUpdate);
            axios.put(`api/posts/${postIdToUpdate}`, {
                    title: editTitle.value,
                    description: editDesc.value,
                })
                .then(response => {
                    console.log(response);
                    document.getElementById('successMsg').innerHTML = `<div class="alert alert-warning alert-dismissible fade show d-flex" role="alert">${response.data.msg}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="false">&times;</span>
                                                                  </button>
                                                                  </div>`;
                    $('#editModal').modal('hide');
                })
                .catch(error => {
                    console.log(error)
                })
        }


        //delete

        function deleteBtn(postId) {

            axios.delete(`api/posts/${postId}`)
                .then(response => {
                    console.log(response.data.msg);
                    document.getElementById('successMsg').innerHTML = `<div class="alert alert-warning alert-dismissible fade show d-flex" role="alert">${response.data.msg}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="false">&times;</span></button></div>`
                })
                .catch(error => {
                    console.log(error)
                })
        }
    </script>






</body>

</html>
