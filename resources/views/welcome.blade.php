<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
                    
                    <div id="alertMsg"></div>
                    <div class="form-group mb-3">
                        <h6>Title</h6>
                        <input type="text" name="title" class="form-control">
                        <span id="titleError" class="text-danger"></span>
                    </div>
                    <div class="form-group mb-3">
                        <h6>Description</h6>
                        <textarea name="description" id="" class="form-control" ></textarea>
                        <span id="descError" class="text-danger"></span>
                    </div>
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

     
      <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    
 
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></scrip> --}}
    <script>
        //read 
        axios.get('/api/posts'
        ).then(response => {
                let result = document.getElementById('result');
                result.innerHTML = response.data.map(item => `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.title}</td>
                        <td>${item.description}</td>
                        <td>
                           <div class="btn-group">
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal" type=button>Edit</button>
                                <button class="btn btn-danger btn-sm">Dlete</button>
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
                        // console.log(response.data);
                        document.getElementById('alertMsg').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+response.data.msg+'</strong> .<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                        createForm.reset();
                    }
                )
                .catch(error => {
                   
                    // console.log(error.response.data.msg.title);
                    // console.log(error.response.data.msg.description);
                    
                    
                    if(titleInput.value == "") {
                        document.getElementById('titleError').innerHTML = '<i>'+error.response.data.msg.title+'</i>';
                    } else {
                        document.getElementById('titleError').innerHTML = '';
                    }

                    if(descInput.value == "") {
                        document.getElementById('descError').innerHTML = '<i>'+error.response.data.msg.description+'</i>';
                    } else {
                        document.getElementById('descError').innerHTML = '';
                    }
                    
                  
                }
                    

                )
        }

        //update


    </script>
    <script src="{{ mix('js/app.js') }}"></script>
     
   
    
</body>

</html>