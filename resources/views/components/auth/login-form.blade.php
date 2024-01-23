<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card w-100  p-4">
                <div class="card-body">
                    <h6>SIGN IN</h6>
                    <br/>
                    <input id="email" placeholder="User Email" class="form-control form-control-sm" type="email"/>
                    <br/>
                    <input id="password" placeholder="User Password" class="form-control form-control-sm" type="password"/>
                    <br/>
                    <button  onclick="Save()"  class="btn w-100 btn-success btn-sm">Next</button>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    async function Save() {

        let email=document.getElementById('email').value;
        let password=document.getElementById('password').value;

        let PostObj={"email":email, "password":password}

        showLoader();
        let res=await axios.post("/userLogin",PostObj)
        hideLoader();

        if(res.data['status']==="success"){
           // alert(res.data['message']);
            window.location.href="/Profile";
        }else {
            alert(res.data['message'])
        }

    }


</script>


