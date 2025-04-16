<!-- resources/views/contact.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact Us</h1>
    
    <p>At Pet Store, we value our customers and are always happy to help! If you have any questions or need assistance, feel free to reach out to us. Below are the best ways to contact us:</p>
    <br>
    <h2>Email</h2>
    <p>If you have any questions or concerns, send us an email at <strong>support@petstore.com</strong>, and our customer service team will respond to you as soon as possible.</p>
    <br>
    <h2>Phone</h2>
    <p>You can also call us at <strong>(60) 12-3456789</strong> during our business hours:</p>
    <p>Monday to Friday, 9 AM - 6 PM.</p>
    <br>
    <h2>Visit Our Shop</h2>
    <p>If you’re local, feel free to drop by our store! Our address is:</p>
    <p><strong>Pet Store</strong><br>
    123 Pet Street, Suite 101<br>
    Pet City, PC 12345</p>
    <br>
    <h2>Social Media</h2>
    <p>Follow us on our social media platforms to stay updated on the latest news, promotions, and adorable pet pictures!</p>
    <ul>
        <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
        <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
        <li><a href="https://www.instagram.com" target="_blank">Instagram</a></li>
    </ul>
    <br>
    <h2>Help Us to Get Better</h2>
    <p>Alternatively, you can fill out the contact form below for any inquiries or feedback, and we’ll get back to you as soon as we can.</p>

    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
@endsection
