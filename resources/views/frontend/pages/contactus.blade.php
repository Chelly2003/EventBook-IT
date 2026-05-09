
@extends('frontend.master')

@section('title', 'Contact Us')

@section('content')


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - Barren</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    :root {
      --primary: #4CAF50;
      --primary-dark: #45a049;
      --gray: #f5f5f5;
      --text: #333;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: var(--text); background:#fafafa; }

    /* Header */
    header {
      background: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .top-nav {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
    }
    .logo {
      font-size: 28px;
      font-weight: bold;
      color: var(--primary);
    }
    .logo span { color: #333; }
    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }
    nav a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color .3s;
    }
    nav a:hover { color: var(--primary); }
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .btn-primary {
      background: var(--primary);
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
    }
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      overflow: hidden;
      border: 2px solid #ddd;
    }
    .user-avatar img { width:100%; height:100%; object-fit:cover; }

    /* Breadcrumb */
    .breadcrumb {
      max-width: 1200px;
      margin: 20px auto;
      padding: 0 20px;
      color: #777;
      font-size: 14px;
    }
    .breadcrumb a { color: var(--primary); text-decoration:none; }

    /* Main Content */
    .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 50px;
      align-items: start;
    }
    h1 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 36px;
    }
    .subtitle {
      text-align: center;
      color: #777;
      margin-bottom: 40px;
    }

    /* Contact Info Card */
    .contact-info {
      background: var(--primary);
      color: #fff;
      padding: 40px;
      border-radius: 10px;
      min-width: 300px;
      flex: 1;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .contact-info h3 {
      font-size: 24px;
      margin-bottom: 15px;
      color: #fff;
    }
    .contact-info p {
      color: rgba(255,255,255,0.9);
      margin-bottom: 25px;
    }
    .info-item {
      display: flex;
      align-items: center;
      gap: 15px;
      color: #fff;
      margin-bottom: 20px;
      font-size: 16px;
    }
    .info-item i {
      font-size: 20px;
      width: 30px;
    }

    /* Form */
    .contact-form {
      flex: 2;
      min-width: 300px;
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }
    .form-group {
      flex: 1;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
    }
    input, textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    input:focus, textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(76,175,80,0.2);
    }
    textarea { height: 120px; resize: vertical; }
    .btn-submit {
      background: var(--primary);
      color: white;
      padding: 14px 40px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background .3s;
    }
    .btn-submit:hover {
      background: var(--primary-dark);
    }

    @media (max-width: 768px) {
      .container { flex-direction: column; }
      .form-row { flex-direction: column; }
      .top-nav { flex-wrap: wrap; height: auto; padding: 15px 0; }
      nav ul { flex-wrap: wrap; gap: 15px; }
    }
  </style>
</head>
 <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="#">Home</a> / Contact Us
  </div>

  <!-- Main Content -->
  <h1>Contact Us</h1>
  <p class="subtitle">Have any questions? We'd love to hear from you.</p>

  <div class="container">
    <!-- Left Side - Contact Info -->
    <div class="contact-info">
      <h3>Contact information</h3>
      <p>Fill out the form and our team will get back to you soon.</p>
      <div class="info-item">
        <i class="fas fa-phone"></i>
        <span>+1 (000) 000-0000</span>
      </div>
      <div class="info-item">
        <i class="fas fa-envelope"></i>
        <span>contact@EventBook-IT.com</span>
      </div>
      <div class="info-item">
        <i class="fas fa-life-ring"></i>
        <span>Help Center</span>
      </div>
    </div>

    <!-- Right Side - Form -->
    <form class="contact-form">
      <div class="form-row">
        <div class="form-group">
          <label>First Name <span style="color:red;">*</span></label>
          <input type="text" required />
        </div>
        <div class="form-group">
          <label>Last Name <span style="color:red;">*</span></label>
          <input type="text" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Email <span style="color:red;">*</span></label>
          <input type="email" required />
        </div>
        <div class="form-group">
          <label>Phone <span style="color:red;">*</span></label>
          <input type="tel" />
        </div>
      </div>

      <div class="form-group">
        <label>Message <span style="color:red;">*</span></label>
        <textarea placeholder="About" required></textarea>
      </div>

      <button type="submit" class="btn-submit">Submit</button>
    </form>
  </div>

@endsection
