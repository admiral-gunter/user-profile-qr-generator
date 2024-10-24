@include('template.base')



<body>
    <section>
      <div class="container">
        <div class="user signinBx">
          <div class="imgBx"><img src="https://raw.githubusercontent.com/WoojinFive/CSS_Playground/master/Responsive%20Login%20and%20Registration%20Form/img1.jpg" alt="" /></div>
          <div class="formBx">
            <form action="" onsubmit="return false;">
              <h2>Sign In</h2>
              <input  name="" placeholder="Email" type="email" onchange="insertLogin(this, 'email')" />
              <input type="password" name="" placeholder="Password"  onchange="insertLogin(this, 'password')"/>
              <input type="submit" name="" value="Login" onclick="login()" />
              <p class="signup">
                Don't have an account ?
                <a href="#" onclick="toggleForm();">Sign Up.</a>
              </p>
            </form>
          </div>
        </div>
        <div class="user signupBx">
          <div class="formBx">
            <form action="" onsubmit="return false;">
              <h2>Create an account</h2>
              <input type="text" name="" placeholder="name" onchange="insertForm(this, 'name')" required />
              <input type="email" name="" placeholder="Email Address"  onchange="insertForm(this, 'email')" required  />
              <input type="password" name="" placeholder="Create Password" onchange="insertForm(this, 'password')" required />
              <input type="password" name="" placeholder="Confirm Password" onchange="insertForm(this, 'confirm_pass')" required  />
              <input type="submit" name="" value="Sign Up" onclick="register()" />
              <p class="signup">
                Already have an account ?
                <a href="#" onclick="toggleForm();">Sign in.</a>
              </p>
            </form>
          </div>
          <div class="imgBx"><img src="https://raw.githubusercontent.com/WoojinFive/CSS_Playground/master/Responsive%20Login%20and%20Registration%20Form/img2.jpg" alt="" /></div>
        </div>
      </div>
    </section>
  </body>


  <script>
    const toggleForm = () => {
  const container = document.querySelector('.container');
  container.classList.toggle('active');
};

const form = {}

function insertForm(inputElement, key){
  form[key] = inputElement.value
  console.log(form)
}

function register() {
  var request = new Request('http://localhost:8000/api/v1/auth/register', {
    method: 'POST',
    body: JSON.stringify(form),
    headers: new Headers({
      'Content-Type': 'application/json'
    })
  });

  fetch(request)
    .then(function(response) {


      return response.json().then(function(data) {

      if (data.token_type == "Bearer") {
          const oneWeek = 7 * 24 * 60 * 60 * 1000; // in milliseconds
        const expirationDate = new Date(Date.now() + oneWeek).toUTCString();

        // Set the cookie with the auth token and expiration date
        document.cookie = `authToken=${data.access_token}; expires=${expirationDate}; path=/`;
        Swal.fire({
          title: "Registered!",
          text: "Let's create your profile!",
          icon: "success"
        }).then(() => {
         window.location.href = 'http://localhost:8000/home'
        });

      
      } else {
        if(data.email){
             Swal.fire({
          title: "Error!",
          text: data.email[0],
          icon: "error"
        })
        }

      }
    });

      // if (response.ok) {
      //   Swal.fire({
      //     title: "Registered!",
      //     text: "Lets create your profile!",
      //     icon: "success"
      //   }).then(()=>{
      //     window.location.href = 'http://localhost:8000/login'
      //   });

      //   const oneWeek = 7 * 24 * 60 * 60 * 1000; // in milliseconds
      //   const expirationDate = new Date(Date.now() + oneWeek).toUTCString();

      //     // Set the cookie with the auth token and expiration date
      //     document.cookie = `authToken=${authToken}; expires=${expirationDate}; path=/`
      // } else {
      //   const resp =  response.json() 
      //   console.log(resp)
      //   throw new Error('Network response was not ok.');
      // }
    })
    .then(function(data) {
      console.log('aasss')
      console.log(data);
    })
    .catch(function(error) {
      console.log(error)
     //  alert('There was a problem with the fetch operation: '+error)
     // Swal.fire({
     //      title: "ERROR!",
     //      text: "'There was a problem with the fetch operation:'"+ error,
     //      icon: "error"
     //    }).then(()=>{
     //    });
     //  console.error('There was a problem with the fetch operation:', error);
    });
}

const loginForm = {}

function insertLogin(inputElement, key) {
  loginForm[key] =inputElement.value
}

function login(){
  var request = new Request('http://localhost:8000/api/v1/auth/login', {
    method: 'POST',
    body: JSON.stringify(loginForm),
    headers: new Headers({
      'Content-Type': 'application/json'
    })
  });

  fetch(request)
    .then(function(response) {
      if (response.ok) {
        Swal.fire({
          title: "Logged in!",
          text: "Lets see your profile!",
          icon: "success"
        }).then(()=>{
          window.location.href = 'http://localhost:8000/home'
        });
        return response.json();
      } else {
        throw new Error('Network response was not ok.');
      }
    })
    .then(function(data) {
      console.log(data.access_token);

      const oneWeek = 7 * 24 * 60 * 60 * 1000; 
      const expirationDate = new Date(Date.now() + oneWeek).toUTCString();

      document.cookie = `authToken=${data.access_token}; expires=${expirationDate}; path=/`
    })
    .catch(function(error) {
      console.error('There was a problem with the fetch operation:', error);
    });
}

  </script>