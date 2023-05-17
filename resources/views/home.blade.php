
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

</style>

<div>
    <div id="containerProfile" class="profile-container" style="background:{{ $user_profile->color ?? 'rgb(243, 243, 133)' }};">
        <div style="width:50%">
            <div style="display:flex; justify-content:center">
                <img src="https://picsum.photos/200" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
            </div>
            
            <div style="text-align: center; margin-top:10px">

                <h4>{{$user_data->name}}</h4>
                <h5>{{$user_data->email}}</h5>
                <div class="">
                    @if ($user_profile && $user_profile->pronounce)
                        <p style="text-align: center">{{$user_profile->pronounce}}</p> 
                    @endif
                    <div style="display: flex; justify-content:center">
                        <div>
                            <i class="fas fa-birthday-cake"></i> 24/11/1990
                        </div>
                    </div>  
    
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
        <div style="width:50%">
            <ul style="list-style:none; margin-top:20px">
                {{-- @if ($user_profile && $user_profile->pronounce)
                <li>
                    <p>{{$user_profile->pronounce}}</p>
                </li>
                @endif --}}
                
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
                        <p style="font-weight: bold; margin:0" class="mb-3"><span><i class="fa-brands fa-black-tie fa-2xl"></i></span> Bio</p>
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
                                        <a href="{{$item->link}}" class="link-primary" target="_blank">{{$item->type}}</a>
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
    <div id="editForm">
        <div style="padding:50px">


            <ul style="list-style:none; margin:0">
                <li>
                    <div class="mb-3">
                        <label class="form-label">Pronounce</label>
                        <input type="email" id="pronounce" class="form-control" style="width: 50%" value="{{$user_profile->pronounce ?? ''}}" />
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
                        <textarea class="form-control" id="bio" placeholder="Describe yourself here" >
                            {{$user_profile->bio ?? ''}}
                        </textarea>
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
                                    <input type="text" placeholder="Enter Type.." value="{{$item->type}}" style="outline: none; border:none" id="input-type-{{$key+1}}"/> 
                                    <input  class="form-control" placeholder="Enter Link.." value="{{$item->link}}" id="input-link-{{$key+1}}"/>
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

</div>

<script>
var qrBtnClicked = false
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

}

var totalToLoop = 0

$(document).ready(function() {
    let id = {!! json_encode(count($data)) !!}
    totalToLoop = id

    $('#socialsAdd').click(function() {
        totalToLoop = totalToLoop + 1
        var newDiv = $(`<div class="form-group mb-3" style="display: flex; justify-content:between" id="item-social-${totalToLoop}">
                            <div  style="width:75%">
                                <input type="text" value="" placeholder="Enter Type.." style="outline: none; border:none" id="input-type-${totalToLoop}"/> 
                                <input  class="form-control" placeholder="Enter Link.." value="" id="input-link-${totalToLoop}"/>
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

    profile['pronounce'] = pronounce
    profile['nationality'] = nationality
    profile['bio'] = bioVal
    profile['color'] = colorPicker

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

  fetch(request)
    .then(function(response) {
      if (response.ok) {
        Swal.fire('Success').then(()=>{
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
  const element = document.getElementById("containerProfile"); 
  const backgroundColor = window.getComputedStyle(element).backgroundColor;
    const userId = {!! json_encode($user_id) !!};
    const whomId = {!! json_encode($whom_id) !!}

  function isDark(color) {
    // extract the RGB values
    const rgb = color.substring(4, color.length-1)
      .replace(/ /g, '')
      .split(',');

    // calculate the perceived brightness
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

</script>
