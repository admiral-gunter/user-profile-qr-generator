
@include('template.base')

<style>
/* .color-change {
animation-name: color-change;
animation-duration: 2s;
animation-iteration-count: infinite;
}

@keyframes color-change {
  0% {
    background-color: rgb(252, 252, 158);
  }
  50% {
    background-color: rgb(207, 207, 107);
  }
  100% {
    background-color: rgb(225, 233, 122);
  }
} */

</style>

<div>
    <div style="display: flex; justify-content:center">
    
        <div style="background:rgb(229, 229, 97);width: 50%; height:100vh; padding:50px">
            <div>
                <div style="display:flex; justify-content:center">
                    <img src="https://picsum.photos/200" style="width: 25%; height:25%; object-fit:contain; border-radius:100%"/>
                </div>
                <div style="text-align: center">
                    <h4>{{$user_data->name}}</h4>
                    <h5>{{$user_data->email}}</h5>
                </div>
            </div>
        </div>
        <div style="width:50%; padding:50px">
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