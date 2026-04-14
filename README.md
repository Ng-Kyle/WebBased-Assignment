TARUMT Web Based Integrated Systems Assignment DFTG4

Title: Figure Shop (AnonFigures)

Members: Ng Kyle, Yaswinraj A/L Sunderamurthi, Nigel Matthias Gregory, Mokwe Makeen Jachike Emir

Precautions ⚠️:
Launch the server on localhost:8000. This is to ensure stripe can redirect you to the correct page after payment.

Import the database under the name anonfigures (same as the file name). The _base file checks for anonfigures as the database name. 

Doing repeated checkouts or password resets in quick succession can cause the host email (anonfigures@gmail.com) to be rate limited.
The emails were sent, you will just receive them at later after gmail unblocks.

The admin login page can be found at http://localhost:8000/admin/admin.php.

Super admin details:

Email: superadmin@gmail.com, Password: sudoAdmin

Nigel Functions
Security:
Login + Logout
Password Hashing
Password Reset

User Profile:
Profile Update
Password Update
Profile Photo Upload

Member Maintenance:
Member Registration
Profile Photo Upload

Additional Functions
Remember Me (Retain Login Session)
Temporary Login Blocking (3 Attempts)
Hide/View Passwords
Logout Confirmation

Emir Functions
Product Maintenance (Admin):
Product Listing + Details
Basic Searching

Shopping Cart (Member):
Product Listing + Details
Basic Searching

Order Maintenance:
Order Listing + Details (Admin)

Additional Features:
Add to Wishlist (Button functionality from product listing page) 
Product Filtering (By Category)
Product Filtering (By Price)
Product Photos Slider (dynamic)
1 Product = Multiple Photos

Yaswinraj Functions:
Member Maintenance:
Member Listing + Details (Admin)
Basic Searching (Admin)

Main Menu + Header

Additional Features:
Order Cancellation (Member)
Order Status Update (Admin)
Top Selling Products
Google Maps Integration (Store location)
Stock Handling (Order Status Update Button)

CSS:
-main menu
-product details (member)
-admin login page
-member list page (admin)
-product details (admin)
-member details (admin) 

Kyle
Database Design + Insertion 
Functions:
Security:
Roles:Admin+Member

Product Maintenance (Admin):
Product CRUD
Product Photo Upload

Shopping Cart (Member):
Shopping Cart
Checkout + Create Order

Order Maintenance:
Order History + Detail (Member)

Additional Features:
Payment (Real - Using Stripe API)
E-Receipt (Email and PDF)
Shipping Address Handling
Add to Favourites or Wishlist (Wishlist Page Functionality)
Product Stock Handling (Member Cart Handling)
Permanent Shopping Cart
