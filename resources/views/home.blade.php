
@include('template.base')

<div>
    <div style="">
        <div  style="background:{{ $user_profile->color ?? 'rgb(243, 243, 133)' }}; width: 100%; height: 100vh; padding:50px; display:flex; justify-content:space-between;">
            <div style="width:40%">
                <div style="display:flex; justify-content:center">
                    <img src="https://picsum.photos/200" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
                </div>
                <div style="text-align: center">
                    <h4>{{$user_data->name}}</h4>
                    <h5>{{$user_data->email}}</h5>

                    <button id="editProfileBtn" class="btn btn-secondary">Edit Profile</button>
                </div>
            </div>
            <div style="width:60%">
                <ul style="list-style:none">
                    @if ($user_profile && $user_profile->pronounce)
                    <li>
                        <p>{{$user_profile->pronounce}}</p>
                    </li>
                    @endif
                    
                    @if ($user_profile && $user_profile->nationality)
                    <li>
                        <p style="font-weight: bold; margin:0">Nationality</p>
                        <p>
                                <span class="fi fi-{{$user_profile->nationality}}"></span>
                        </p>
                    </li>
                    @endif

                    @if ($user_profile && $user_profile->bio)
                        <li>
                            <p style="font-weight: bold; margin:0">Bio</p>
                            <div style="width: 50%">
                                {{$user_profile->bio}}
                            </div>
                        </li>    
                    @endif


                    @if ($data)
                        <li>
                            <div>
                                <p style="font-weight: bold; margin:0">Social accounts</p>
                                <ul style="list-style:none; padding:0">
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
                            <textarea class="form-control" id="bio" placeholder="Describe yourself here" value="{{$user_profile->bio ?? ''}}" ></textarea>
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
                <button  class="btn btn-secondary" onclick="generateQR()">generate QR</button>
                
                <div id="qrcode"></div>
        
            </div>
        </div>
        @endif

    </div>
</div>

<script>
function generateQR() {
    var user_id = {!! json_encode($user_id) !!};
    const qrcode = new QRCode(document.getElementById('qrcode'), {
    text: 'http://localhost:8000/user-socials/qr/'+user_id,
    width: 128,
    height: 128,
    colorDark : '#000',
    colorLight : '#fff',
    correctLevel : QRCode.CorrectLevel.H
    });
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


</script>

<?php

function myValue($data,$prop){
    foreach ($data as $value) {
        if($value->type == $prop){
            return $value->link;
        }
    }
}