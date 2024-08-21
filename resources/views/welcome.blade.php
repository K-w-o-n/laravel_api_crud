<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer>
    </script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Laravel Api Documentation</title>
</head>

<body>
    <div class="container" style="padding-top: 100px;">
        <h1 class="text-center mb-5">Laravel Api Crud</h1>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered table-striped p-3">
                    <h3>Posts</h3>
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
                    
                    <span id="alertMsg"></span>
                    <div class="form-group mb-3">
                        <h6>Title</h6>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <h6>Description</h6>
                        <textarea name="description" id="" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>



   
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <script>
        //read 
        axios({
            method: 'get',
            url: '/api/posts'
        }).then(response => {
                let result = document.getElementById('result');
                result.innerHTML = response.data.map(item => `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.title}</td>
                        <td>${item.description}</td>
                        <td>
                           <div class="btn-group">
                                <button class="btn btn-success btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Dlete</button>
                           </div> 
                        </td>
                    </tr>
    `).join('');
            }


        ).catch(error => {

            console.log(error.response.status);

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
                .then(
                    response => {
                        console.log(response);
                        document.getElementById('alertMsg').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+response.data.msg+'</strong> .<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    }
                )
                .catch(
                    error => console.log(error.response)
                )
        }
    </script>
</body>

</html>