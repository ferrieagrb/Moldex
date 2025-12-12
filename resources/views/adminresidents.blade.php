@extends('layout.adminlayout')
@section('title')
    <title>Tenant Pro | Admin Residents</title>
@endsection
@section('content')

<header>
    <p id="greetings">Residents</p>
</header>

<div class="boxes">
    @foreach ($residents as $resi)
        <div class="users"
            style="cursor: pointer;"
            onclick="openUserEditModal(
                {{ $resi->id }},
                '{{ $resi->first_name }}',
                '{{ $resi->last_name }}',
                '{{ $resi->middle_name }}',
                '{{ $resi->date_of_birth }}',
                '{{ $resi->contact_number }}',
                '{{ $resi->tel_number }}',
                '{{ $resi->nationality }}',
                '{{ $resi->address }}',
                '{{ $resi->email }}',
                '{{ $resi->name }}',
                '{{ $resi->room_no }}'
            )">
            <p>{{ $resi->first_name }} {{ $resi->last_name }}</p>
        </div>
    @endforeach
</div>

<!-- Edit User Modal -->
<div id="editUserModal"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">

    <div style="background:white; padding:20px; border-radius:8px; width:350px; text-align:center;">
        <h3>Edit User</h3>

        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text" id="editFname" name="first_name" placeholder="First Name" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editLname" name="last_name" placeholder="Last Name" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editMname" name="middle_name" placeholder="Middle Name" style="width:100%; margin-bottom:10px;">
            <input type="date" id="editBdate" name="date_of_birth" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editContact" name="contact_number" placeholder="Contact Number" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editTelno" name="tel_number" placeholder="Tel Number" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editNationality" name="nationality" placeholder="Nationality" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editAddress" name="address" placeholder="Address" style="width:100%; margin-bottom:10px;">
            <input type="email" id="editEmail" name="email" placeholder="Email" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editUsername" name="name" placeholder="Username" style="width:100%; margin-bottom:10px;">
            <input type="text" id="editRoom" name="room_no" placeholder="Room#" style="width:100%; margin-bottom:10px;">

            <button type="submit">Save Changes</button>
            <button type="button" onclick="closeUserEditModal()" style="margin-top:10px;">Cancel</button>
        </form>
    </div>
</div>

<script>
function openUserEditModal(id, fname, lname, mname, bdate, contact, telno, nationality, address, email, username, room) {

    document.getElementById('editFname').value = fname;
    document.getElementById('editLname').value = lname;
    document.getElementById('editMname').value = mname;
    document.getElementById('editBdate').value = bdate;
    document.getElementById('editContact').value = contact;
    document.getElementById('editTelno').value = telno;
    document.getElementById('editNationality').value = nationality;
    document.getElementById('editAddress').value = address;
    document.getElementById('editEmail').value = email;
    document.getElementById('editUsername').value = username;
    document.getElementById('editRoom').value = room;

    document.getElementById('editUserForm').action = `/admin/update-user/${id}`;

    document.getElementById('editUserModal').style.display = 'flex';
}

function closeUserEditModal() {
    document.getElementById('editUserModal').style.display = 'none';
}
</script>

@endsection
