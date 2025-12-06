@extends('layout.adminlayout')

@section('content')

<header>
        <p id="main-header">Create An Account</p>
    </header>
    
       <style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .content {
        margin: 30px auto;
        width: 95%;
        max-width: 1500px;
    }

    /* Main page header */
    #main-header {
        font-size: 32px;
        font-weight: 700;
        color: #333333;
        margin-bottom: 20px;
        text-align: left;
    }

    /* Section header inside form */
    #greetings {
        font-size: 28px;
        font-weight: 400;
        color: #6c6c6c;
        margin-bottom: 20px;
        text-align: left;
    }

    /* Form boxes */
    .form-box,
    
    .form-box {
    margin-top: 20px;
    padding: 40px 50px;
    width: 100%;
    max-width: 1600px; /* increased max-width to expand to the right */
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    position: relative;
}
    
    .smaller-box {
    margin-top: 20px;
    padding: 30px 40px;
    width: 100%;
    max-width: 1800px; 
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    position: relative;
    padding-bottom: auto; 
    margin-left: 0;
    margin-right: 0; 
    }
    /* Rows */
    .row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .col {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    /* Labels */
    label {
        font-size: 14px;
        color: #4a4a4a;
        margin-bottom: 6px;
    }

    /* Inputs */
    input {
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #dcdcdc;
        font-size: 16px;
        width: 100%;
        background: #fdfdfd;
        box-sizing: border-box;
    }

    /* Smaller inputs */
    .small-input {
        padding: 12px 15px;
        font-size: 14px;
        border-radius: 8px;
    }

    /* Buttons */
    .btn-tiny {
        background: #52d11b;
        padding: 10px 25px;
        font-size: 14px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        color: #fff;
        transition: background 0.2s ease;
    }

    .btn-tiny:hover {
        background: #42b314;
    }

    /* Button wrapper */
    .btn-tiny-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    /* Inputs wrapper in smaller box */
    .inputs-wrapper {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .form-box,
        .smaller-box {
            max-width: 95%;
            padding: 30px 35px;
        }
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
            gap: 15px;
        }
        .btn-tiny-wrapper {
            justify-content: center;
        }
        .btn-tiny {
            width: 100%;
            text-align: center;
        }
    }
</style>


    
   <div class="content">

    <!-- MAIN FORM BOX -->
    <div class="form-box">

        <!-- NAME -->
        <div class="row">
            <div class="col">
                <label>Last name</label>
                <input type="text" required>
            </div>
            <div class="col">
                <label>First name</label>
                <input type="text" required>
            </div>
            <div class="col">
                <label>Middle name</label>
                <input type="text" required>
            </div>
        </div>

        <!-- ADDRESS -->
        <div class="row">
            <div class="col" style="flex: 3;">
                <label>Address</label>
                <input type="text" required>
            </div>
            <div class="col">
                <label>Lot/Room no.</label>
                <input type="text" required>
            </div>
        </div>

        <!-- DOB AND NATIONALITY -->
        <div class="row">
            <div class="col">
                <label>Date of Birth</label>
                <input type="date" required>
            </div>
            <div class="col">
                <label>Nationality</label>
                <input type="text" required>
            </div>
        </div>

        <!-- CONTACT INFO -->
        <div class="row">
            <div class="col">
                <label>Contact Number</label>
                <input type="text" required>
            </div>
            <div class="col">
                <label>Telephone Number</label>
                <input type="text">
            </div>
            <div class="col">
                <label>Email Address</label>
                <input type="email" required>
            </div>
        </div>

    </div>

    <!-- USERNAME/PASSWORD BOX -->
   <div class="smaller-box">

    <div class="row">
        <div class="col">
            <label>Username</label>
            <input type="text" class="small-input" required>
        </div>
        <div class="col">
            <label>Password</label>
            <input type="password" class="small-input" required>
        </div>
    </div>

     <div class="btn-tiny-wrapper">
        <button class="btn-tiny">CONTINUE</button>
    </div>

</div>
@endsection