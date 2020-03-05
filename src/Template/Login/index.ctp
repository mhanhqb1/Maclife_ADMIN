<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="box login-box">
            <div class="login-image">
                <img src="https://img.cg4vn.net/images/Asset%202.png" alt="login image" />
            </div>
            <div class="box-header">
                <h1 class="box-title">SIGN IN TO START YOUR SESSION</h1>
            </div>
            <div class="box-body">
                <?php 
                    echo $this->SimpleForm->render($loginForm); 
                ?>
            </div>
        </div>
    </div>
</div>
