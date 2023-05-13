@include('template.base')

<div>
    @foreach ($socials as $soc)
        <div class="form-group">
        <label for="exampleInputEmail1">{{$soc->name}}</label>
            <input  class="form-control" id="{{$soc->id}}" placeholder="Enter Your {{$soc->name}}" onchange="prepareForms('{{$soc->id}}')" />
        </div>
    @endforeach
    <button type="submit" class="btn btn-primary" onclick="submitForm()">Submit</button>
</div>

<script>

const form = {}

function prepareForms(id) {
    const value = $(`#${id}`).val()
    form[id] = value
    console.log($(`#${id}`).val())
}

function submitForm() {
    
}
</script>