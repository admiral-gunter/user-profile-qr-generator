
@include('template.base')

<div>
    <div style="">
        <div style="background:rgb(243, 243, 133);width: 100%; height: 100vh; padding:50px; display:flex; justify-content:space-between;">
            <div style="width:40%">
                <div style="display:flex; justify-content:center">
                    <img src="https://picsum.photos/200" style="width: 150px; height: 150px; object-fit:contain; border-radius:100%"/>
                </div>
                <div style="text-align: center">
                    <h4>{{$user_data->name}}</h4>
                    <h5>{{$user_data->email}}</h5>
                </div>
            </div>
            <div style="width:60%">
                <ul style="list-style:none">
                    <li>
                        <p>She/Her</p>
                    </li>
                    <li>
                        <p style="font-weight: bold; margin:0">Nationality</p>
                        <p>
                            <span class="fi fi-jp"></span>
                        </p>
                    </li>
                    <li>
                        <p style="font-weight: bold; margin:0">Bio</p>
                        <p style="width: 50%">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi, suscipit, atque molestias inventore beatae sunt provident at corrupti nesciunt vero amet sequi perferendis dolor placeat voluptatem consequuntur hic molestiae illo!
                        </p>
                    </li>
                </ul>

                <div>
                    <ul style="list-style:none">
                        @foreach ($data as $key=> $item)
                            <li>
                                <a href="{{$item->link}}" target="_blank">{{$item->type}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
          
        </div>
        @if ($whom_id == $user_id)
            <div style="padding:50px">
                <div id="listSocial">
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
        

                @if ($whom_id == $user_id)
                    
                <button  class="btn btn-success" id="socialsAdd">Add</button>
                <button  class="btn btn-primary" onclick="submit()">Submit</button>
                @endif
                <button  class="btn btn-secondary" onclick="generateQR()">generate QR</button>
                
                <div id="qrcode"></div>
        
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
    const itemSubmit = {'value':itemsValue}

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

    console.log(itemsValue)

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
</script>

<?php

function myValue($data,$prop){
    foreach ($data as $value) {
        if($value->type == $prop){
            return $value->link;
        }
    }
}