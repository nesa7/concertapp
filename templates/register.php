<head>
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color:#F5F5F5;">
    <div class="container">
        <div class="row justify-content-md-center" style="margin-top: 10rem;">
            <div class="col-6 align-items-center ">

                <h1 style="text-align:center;">Register and find out about concerts near you!</h1>
                <form action="?command=register" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div id="pwhelp" class="form-text"></div>
                    </div>
                    <button class="btn btn-primary float-end" type="submit">Submit</button>
                </form>
                <p>Already have an account? <a href="?command=login">Login here</a></p>
            </div>
        </div>
    </div>
</body>

</html>