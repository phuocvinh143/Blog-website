<?php
require('includes/db.inc.php');
include('includes/function.php');
if (!isset($_SESSION['isUserLoggedIn'])) {
  redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/style.css" rel="stylesheet">
  <link href="custom-bootstrap.css" rel="stylesheet">
  <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
  <title>
    Manage Account
  </title>
  <link rel="icon" href="images/icon.jpg" type="image/x-icon">
  <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function getAllPostInfo(selectedPostID) {
      if (selectedPostID == "") return
      console.log(selectedPostID);
      var xmlhttp = new XMLHttpRequest()
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var review = JSON.parse(this.responseText)[0]
          for (key in review) {
            document.getElementsByName(key)[0].value = review[key]
          }
        }
      }
      xmlhttp.open('GET', "includes/modify_post.php?post_id=" + selectedPostID, true)
      xmlhttp.send()
    }
  </script>
</head>

<body>
  <!-- Modal Add Category -->
  <div class="modal fade" id="modalCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add new category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="includes/add_category.php" method="post">
            <div class="form-group">
              <label class="col-form-label">Catagory Name</label>
              <input type="text" class="form-control" name="category_name" required>
            </div>
            <button type="submit" name="addct" class="btn btn-primary" style="margin-top: 10px">Add Category</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Add Category -->

  <!-- Navigation bar -->
  <?php include_once('includes/navbar.php'); ?>

  <section class="container">
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <?php
            if (isset($_GET['managepost'])) {
            ?>
              <!-- Manage Post -->
              <div class="row">
                <div class="col-lg-12">
                  <header class="panel-heading">
                    <h3>Manage Post</h3>
                    <a class="btn btn-warning" href="admin.php?modifypost">Modify Post</a>
                  </header>
                  <section class="panel">
                    <table class="table table-striped table-advance table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Post Title</th>
                          <th>Post Category</th>
                          <th>Post Date</th>
                          <th>Action</th>
                        </tr>
                        <?php
                        $index = 0;
                        $posts = getAllPostsByAdmin($conn, $_SESSION['email']);
                        foreach ($posts as $post) {
                        ?>
                          <tr>
                            <td><?= ++$index ?></td>
                            <td><?= $post['title'] ?></td>
                            <td><?= getCategory($conn, $post['category_id']) ?></td>
                            <td><?= date('F jS Y', strtotime($post['create_at'])) ?></td>
                            <td>
                              <div class="d-grid gap-2 d-md-block">
                                <a class="btn btn-danger" href="includes/remove_post.php?id=<?= $post['p_id'] ?>">Delete</a>
                              </div>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </section>
                </div>
              </div>
              <!-- end manage post -->
            <?php
            } elseif (isset($_GET['managecomment'])) {
            ?>
              <!-- Manage Comment -->
              <div class="row">
                <div class="col-lg-12">
                  <header class="panel-heading">
                    <h3>Manage Comment</h3>
                  </header>
                  <section class="panel">
                    <table class="table table-striped table-advance table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Comment</th>
                          <th>Name</th>
                          <th>Post</th>
                        </tr>
                        <?php
                        $comments = getAllCommentsByAdmin($conn, $_SESSION['email']);
                        $index = 0;
                        foreach ($comments as $comment) {
                        ?>
                          <tr>
                            <td><?= ++$index ?></td>
                            <td><?= $comment['comment'] ?></td>
                            <td><?= $comment['name'] ?></td>
                            <td><?= getPostTitle($conn, $comment['post_id']) ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </section>
                </div>
              </div>
              <!-- end manage comment -->
            <?php
            } elseif (isset($_GET['modifypost'])) {
            ?>
              <!-- Modify Post -->
              <div class="col-lg-12">
                <section class="panel">
                  <div class="panel-body">
                    <div class="form">
                      <form action="includes/update_post.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                          <label>Choose Your Old Post Title</label>
                          <select class="form-select form-select-sm-12" name="post_id_for_modify" onchange="getAllPostInfo(this.value)">
                            <?php
                            $posts = getAllPostsByAdmin($conn, $_SESSION['email']);
                            foreach ($posts as $option) {
                            ?>
                              <option value="<?php echo $option['p_id'] ?>"><?= $option['title'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label>Update Post Title To </label>
                          <input type="text" class="form-control col-sm-12" name="title" required />
                        </div>

                        <div class="form-group">
                          <label>Post Content To</label>
                          <textarea class="form-control" name="content" style="height: 230px"></textarea>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-6" style="float: left; width: 50%">
                            <label>Select Post Category</label>
                            <select class="form-control" name="category_id">
                              <?php
                              $categories = getAllCategory($conn);
                              foreach ($categories as $option) {
                              ?>
                                <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-sm-6" style="float: right; width: 45%">
                            <label>Upload Photos <small style="font-weight: normal"> (All these photos will replace your current photos post) </small></label>
                            <input type="file" class="form-control" name="post_update_image[]" multiple />
                          </div>
                        </div>
                        <div class="form-group">
                          <input class="btn btn-primary" type="submit" name="update_post" value="Update Post" style="margin-top: 20px">
                        </div>
                      </form>
                    </div>
                  </div>
                </section>
              </div>
              <!-- End Modify Post -->
            <?php
            } elseif (isset($_GET['managecategory']) && $_SESSION['email'] == 'maiphuocvinh@gmail.com') {
            ?>
              <!-- Manage Category -->
              <div class="row">
                <div class="col-lg-12">
                  <header class="panel-heading">
                    <h3>Manage Category</h3>
                    <button class="btn btn-primary" data-bs-target="#modalCategory" data-bs-toggle="modal">Add New Category</button>
                  </header>
                  <section class="panel">
                    <table class="table table-striped table-advance table-hover">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th>Category Name</th>
                          <th>Action</th>
                        </tr>
                        <?php
                        $categories = getAllCategory($conn);
                        foreach ($categories as $ct) {
                        ?>
                          <tr>
                            <td><?= $ct['id'] ?></td>
                            <td><?= $ct['name'] ?></td>
                            <td>
                              <div class="btn-group">
                                <a class="btn btn-danger" href="includes/remove_category.php?id=<?= $ct['id'] ?>">Remove</a>
                              </div>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </section>
                </div>
              </div>
              <!-- end mange category -->
            <?php
            } else {
            ?>
              <!-- Add Post -->
              <div class="col-lg-12">
                <section class="panel">
                  <div class="panel-body">
                    <div class="form">
                      <form action="includes/add_post.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="identifier">
                        <div class="form-group">
                          <label>Post Title </label>
                          <input type="text" class="form-control col-sm-12" name="post_title" required>
                        </div>

                        <div class="form-group">
                          <label>Post Abstract</label>
                          <textarea class="form-control" name="post_abstract" style="height: 100px"></textarea>
                        </div>

                        <div class="form-group">
                          <label>Post Content</label>
                          <div id="quillArea" style="height: 230px;"></div>
                          <textarea name="post_content" style="display:none;" id="hiddenArea"></textarea>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-6" style="float: left; width: 50%">
                            <label>Select Post Category</label>
                            <select class="form-control" name="post_category">
                              <?php
                              $categories = getAllCategory($conn);
                              foreach ($categories as $option) {
                              ?>
                                <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-sm-6" style="float: right; width: 45%">
                            <label>Upload Photos </label>
                            <input type="file" class="form-control" name="post_image[]" multiple />
                          </div>
                        </div>
                        <div class="form-group">
                          <input class="btn btn-primary" type="submit" name="add_post" value="Add Post" style="margin-top: 20px">
                        </div>
                      </form>
                    </div>
                  </div>
                </section>
              </div>
              <!-- end Add Post -->
            <?php
            }
            ?>
            <script>
              var quill = new Quill('#quillArea', {
                      placeholder: 'Enter Content',
                      theme: 'snow',
                      modules: {
                          toolbar: [
                              ['bold', 'italic', 'underline', 'strike'],
                              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                              [{ 'indent': '-1'}, { 'indent': '+1' }]
                          ]
                      }
                  });
              $("#identifier").on("submit",function(){
                $("#hiddenArea").val(quill.root.innerHTML.trim());
              });
              
            </script>
          </div>
        </div>
      </section>
    </section>
  </section>
</body>

</html>