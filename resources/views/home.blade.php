
@include('template.base')

<style>
@media only screen and (max-width: 600px) {
    .profile-container {
        height: 100%;
    }
}

@media only screen and (min-width: 800px) {
    .profile-container {
        display:flex;
        justify-content:space-between;
        height:100vh;
        padding:50px;
    }
}

@media only screen and (max-width: 600px) {
    .sub-profile-container {
        widh:100%;
        height:100%;
    }
}

@media only screen and (min-width: 800px) {
    .sub-profile-container {
        width: 50%;
        height:100%;
    }
}

</style>

{{-- <div> --}}
    <div id="containerProfile" class="profile-container" style="background:{{ $user_profile->color ?? 'rgb(243, 243, 133)' }};">
        <div class="sub-profile-container">
            <div style="display:flex; justify-content:center">
                @if ($user_profile && $user_profile->picture)
                    <img src="{{ asset('uploads/'.$user_profile->picture)}}" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
                @else
                    <img src="https://picsum.photos/200" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
                @endif
            </div>
            
            <div style="text-align: center; margin-top:10px">
                <h4>{{$user_data->name}}</h4>
                <h5>{{$user_data->email}}</h5>
                <div class="">
                    @if ($user_profile && $user_profile->pronounce)
                        <p style="text-align: center">{{$user_profile->pronounce}}</p> 
                    @endif

                    @if ($user_profile && $user_profile->date_birth)
                    <div style="display: flex; justify-content:center">       
                        <div>
                            <i class="fas fa-birthday-cake"></i> {{ date('d/m/Y', strtotime($user_profile->date_birth))}}
                        </div>
                    </div>  
                    @endif
    
                </div>
                <div style="display: flex; justify-content:center" id="yoursOnly">
                    <ul  style="list-style:none; padding:0; width:200px">
                        <li class="mb-3">
                            <button id="editProfileBtn" class="btn btn-primary w-100">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-danger w-100" onclick="deleteAllCookies()">
                                <i class="fas fa-sign-out-alt"></i>
                        </li>

                        
                    </ul>
                </div>
                <div>
                    <button class="btn btn-info" style="width: 200px" onclick="generateQR()">
                        <i class="fa-solid fa-qrcode"></i>
                    </button>
                </div>

                <div style="display: flex; justify-content:center;">
                    <div id="qrcode" style=" background:white; padding:10px"></div>
                </div>

            </div>
        </div>
        <div class="sub-profile-container">
            <ul style="list-style:none; margin-top:20px">
                
                @if ($user_profile && $user_profile->nationality)
                <li>
                    <p style="font-weight: bold; margin:0"  ><span><i class="fa-solid fa-globe fa-2xl"></i></span>  Nationality</p>
                    <p class="py-2">
                            <span style="width:30px; height:30px" class="fi fi-{{$user_profile->nationality}}"></span>
                    </p>
                </li>
                @endif

                @if ($user_profile && $user_profile->bio)
                    <li>
                        <p style="font-weight: bold; margin:0" class="mb-3">
                            <span><i class="fas fa-signature fa-2xl"></i></span>
                            Bio
                        </p>
                        <div style="width: 80%">
                            {{$user_profile->bio}}
                        </div>
                    </li>    
                @endif


                @if ($data)
                    <li>
                        <div style="margin-top: 50px">
                            <p style="font-weight: bold; margin:0" class="mb-3"><i class="fa-solid fa-link fa-2xl"></i> Social accounts</p>
                            <ul style="list-style:none; padding:0" >
                                @foreach ($data as $key=> $item)
                                    <li>
                                        <a href="{{$item->link}}" style="color:lightcoral;" class="link-primary" target="_blank">{{$item->type}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>

        </div>
        
    </div>
    @if ($whom_id == $user_id)
    <div id="editForm" style="background: white">
        <div style="padding:40px">


            <ul style="list-style:none; margin:0; padding:0">
                <li>
                    <div class="mb-3">
                        <label class="form-label">Pronounce</label>
                        <input type="email" id="pronounce" class="form-control" style="width: 50%" value="{{$user_profile->pronounce ?? ''}}" />
                    </div>
                </li>

                <li>
                    <div class="mb-3">
                        <label class="form-label">Picture</label>

                        <form id="uploadForm">

                             @if ($user_profile && $user_profile->picture)
                                <img id="imgPreview" src="{{ asset('uploads/'.$user_profile->picture)}}" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
                            @else
                                <img id="imgPreview" src="https://picsum.photos/200" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
                            @endif

                            <input type="file" id="fileInput" name="file">
                          </form>
                          
                    </div>
                </li>

                <li>
                    <div class="mb-3">
                        <label class="form-label">Date Birth</label>
                        <input type="date" id="dateBirth" class="form-control" style="width: 50%" value="{{$user_profile->date_birth ?? ''}}" />
                    </div>
                </li>

                <li>
                    <div class="mb-3">
                        <label class="form-label">Nationality</label>
                        <input type="text" id="nationality" placeholder="" class="form-control" style="width: 5%" value="{{$user_profile->nationality ?? ''}}"/>
                        <div class="form-text">Use initial such as jp for Japan, af for Afghanistan, and so on</div>
                    </div>
                </li>
                <li>
                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" placeholder="Describe yourself here" >{{$user_profile->bio ?? ''}}</textarea>
                    </div>
                </li>

                <li>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" id="color-picker" value="{{$user_profile->color ?? '#F3F385'}}" />
                        <div class="form-text">This color will be used for your background profile</div>
                    </div>
                </li>

                <li>
                    <div id="listSocial">
                        <p style="font-weight: bold; margin:0">Social accounts</p>
                        @foreach ($data as $key=> $item)
                            <div class="form-group mb-3" style="display: flex; justify-content:between" id="item-social-{{$key+1}}">
                                <div  style="width:75%">
                                    <input type="text" class="form-control"  placeholder="Enter Type.." value="{{$item->type}}" id="input-type-{{$key+1}}"/> 
                                    <input style="margin-top:1%"  class="form-control" placeholder="Enter Link.." value="{{$item->link}}" id="input-link-{{$key+1}}"/>
                                </div>
                                @if ($whom_id == $user_id)
                                <div class="mt-4" style="margin: auto">
                                    <p style="font-weight: bold; color:white; padding:10px; background:rgb(255, 108, 108); border-radius:5px" onclick="removeThis({{$key+1}})">X</p>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </li>
            </ul>


    

            @if ($whom_id == $user_id)
                
            <button  class="btn btn-success" id="socialsAdd">Add</button>
            <button  class="btn btn-primary" onclick="submit()">Submit</button>
            @endif
            {{-- <button  class="btn btn-secondary" onclick="generateQR()">generate QR</button> --}}
            
    
        </div>
    </div>
    @endif

{{-- </div> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
var qrBtnClicked = false


function downloadDivAsImage() {
    const element = document.getElementById('qrcode');
    html2canvas(element).then(canvas => {
        const imageURL = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.href = imageURL;
        link.download = 'qrcode.png';
        link.click();
    });
}
function generateQR() {    
    if(qrBtnClicked){
        return;
    }

    var user_id = {!! json_encode($user_id) !!};
    const qrcode = new QRCode(document.getElementById('qrcode'), {
    text: 'http://localhost:8000/user-socials/qr/'+user_id,
    width: 128,
    height: 128,
    colorDark : '#000',
    colorLight : '#fff',
    correctLevel : QRCode.CorrectLevel.H
    });

    qrBtnClicked = true

    downloadDivAsImage()

}

var totalToLoop = 0

$(document).ready(function() {
    let id = {!! json_encode(count($data)) !!}
    totalToLoop = id

    $('#socialsAdd').click(function() {
        totalToLoop = totalToLoop + 1
        var newDiv = $(`<div class="form-group mb-3" style="display: flex; justify-content:between" id="item-social-${totalToLoop}">
                            <div  style="width:75%">
                                <input type="text"  class="form-control" value="" placeholder="Enter Type.."  id="input-type-${totalToLoop}"/> 
                                <input  class="form-control" placeholder="Enter Link.." style="margin-top:1%" value="" id="input-link-${totalToLoop}"/>
                            </div>
                            <div class="mt-4" style="margin: auto">
                                <p style="font-weight: bold; color:white; padding:10px; background:rgb(255, 108, 108); border-radius:5px" onclick="removeThis(${totalToLoop})">X</p>
                            </div>
                        </div>`);

        $('#listSocial').append(newDiv);
    });


});

function removeThis(param) {
    const target = "#item-social-"+param
    $(target).remove()
}

function submit() {
    const itemsValue = []
    const profile = {}
    const itemSubmit = {'value':itemsValue, 'profile':profile}

    const pronounce = $('#pronounce').val()
    const nationality = $('#nationality').val()
    const bioVal = $('#bio').val()
    const colorPicker = $('#color-picker').val()
    const dateBirth = $('#dateBirth').val()
    const picture = document.getElementById('picture')

    profile['pronounce'] = pronounce
    profile['nationality'] = nationality
    profile['bio'] = bioVal
    profile['color'] = colorPicker
    profile['date_birth'] = dateBirth   
    // profile['picture'] = picture.files[0]

    for (let i = 0; i < totalToLoop; i++) {
        const index = i+1

        const targetType = "#input-type-"+index

        const targetLink = "#input-link-"+index

        const valLink = $(targetLink).val()
        const valType = $(targetType).val()

        if(valLink && valType){
            itemsValue.push(
                {
                    'link':valLink,
                    'type':valType
                }
            )
        }
    }

    var request = new Request('http://localhost:8000/api/v1/user-socials/add', {
        method: 'POST',
        body: JSON.stringify(itemSubmit),
        headers: new Headers({
            'Content-Type': 'application/json'
        })
    });

    const file = fileInput.files[0]; 

      const formData = new FormData();

      formData.append('picture', file);



      fetch('http://localhost:8000/api/v1/user-socials/add', {
        method: 'POST',
        body: formData
      })
        .then(response => {
          if (response.ok) {
            console.log('File uploaded!');
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });

              fetch(request)
    .then(function(response) {
      if (response.ok) {
        Swal.fire({
            title: "Success!",
            text: "The changes have been saved!",
            icon: "success"
        }).then(()=>{
            // Scroll to top smoothly

            location.reload();
        });
      } else {
        throw new Error('Network response was not ok.');
      }
    })
    .then(function(data) {
      console.log(data);
    })
    .catch(function(error) {
      console.error('There was a problem with the fetch operation:', error);
    });

          } else {
            console.error('Upload failed.');
          }
        })
        .catch(error => {
          console.error('Upload failed.', error);
        });


}


document.getElementById('editProfileBtn').addEventListener('click', function() {
  var target = document.getElementById('editForm');
  if (target) {
    window.scrollTo({
      top: target.offsetTop,
      behavior: 'smooth'
    });
  }
});

function deleteAllCookies() {
    const cookies = document.cookie.split(";");

    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
    localStorage.clear()
    location.reload();
}

document.addEventListener("DOMContentLoaded", function() {
    var body = document.body;
    var bg =  {!! json_encode($user_profile->color ?? '') !!};

    if(bg){
        body.style.backgroundColor = bg;
    }


    const element = document.getElementById("containerProfile"); 
    const backgroundColor = window.getComputedStyle(element).backgroundColor;
    const userId = {!! json_encode($user_id) !!};
    const whomId = {!! json_encode($whom_id) !!}

    function isDark(color) {
        const rgb = color.substring(4, color.length-1)
        .replace(/ /g, '')
        .split(',');

        const brightness = Math.round(((parseInt(rgb[0]) * 299) +
                        (parseInt(rgb[1]) * 587) +
                        (parseInt(rgb[2]) * 114)) / 1000);
        
        return brightness <= 125;
    }

    if(userId != whomId){
        const target = document.getElementById('yoursOnly')
        target.remove()
    }

    if (isDark(backgroundColor)) {
        element.style.color = "white";
    } else {
        element.style.color = "black";
    }
});


const form = document.getElementById('uploadForm');
const fileInput = document.getElementById('fileInput');
const imgPreview = document.getElementById('imgPreview');


fileInput.addEventListener('change', function() {
    const file = fileInput.files[0]; 

if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imgPreview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }

  
});


</script>
