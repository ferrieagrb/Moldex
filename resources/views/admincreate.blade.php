@extends('layout.adminlayout')

@section('content')

<header>
        <p id=greetings>Create An Account</p>
    </header>
    
    <style>
        .content{
            margin-left: 30px;
            padding: 40px 60px;
        }

        .title{
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .form-box{
            width: 900px;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08)
        }
        .row{
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        input{
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            font-size: 15px;
            width: 100%;
        }
        label{
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        .btn{
            background: #2cd32c;
            border: none;
            padding: 14px;
            width: 100%;
            color: #fff;
            font-size: 18px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
        }
        .btn:hover{
            background: #24b624;
        }
        .col{
            flex: 1;
        }
    </style>
@endsection