# The Black Perch — Screen Breakdown & Developer Prompts

Source: `restaurant.png` (UI kit preview — "The Black Perch" food delivery app, 25+ iOS screens)

This document breaks the mockup down into **27 individual screens**, grouped by flow, and gives a **ready-to-use prompt** for each one so a senior fullstack developer (or an AI coding assistant) can generate the page as a standalone `.php` file styled with **Bootstrap 5**, fully **responsive** from small (mobile) to large (desktop) breakpoints.

Use the **Global Design System Prompt** first so every page shares the same look, then feed each **Screen Prompt** in one at a time.

---

## 0. Global Design System Prompt (paste first, once)

```
Build a PHP + Bootstrap 5 web app called "The Black Perch" (food delivery).
Use this design system across every page:

BRAND
- Logo: monkey mascot icon + wordmark "The Black Perch" (tagline: "FOOD DELIVERY")
- Primary color: orange #ffd168  (buttons, active states, price highlights)
- Secondary/dark text: #3f2d16
- Muted/gray text: #9CA3AF
- Background: #010101 (cards) on #010101 (page background)
- Success/badge green: #22C55E, Star rating gold: #7f5923 
- Font: 'Poppins' or 'Nunito Sans' from Google Fonts, rounded and friendly
- Corner radius: large (16px–24px) on cards, buttons, and inputs (pill-style buttons)
- Buttons: solid orange primary button, full width on mobile, pill-shaped,
  with a light-outline secondary button variant ("Create an Account", "Add Card")
- Bottom navigation bar (mobile): fixed, 5 icons — Menu, Offers, Home (raised circular
  button), Profile, More — using Bootstrap's navbar fixed-bottom, collapses into a
  left sidebar or top navbar on desktop (>=992px)

TECH STACK / STRUCTURE
- Bootstrap 5 via CDN (CSS + JS bundle)
- Bootstrap Icons (bi-*) via CDN for iconography
- File extension: .php for every page (even static-looking ones), so they can later
  receive PHP logic/session/DB calls without renaming
- Shared partials included via PHP `include`:
    - includes/header.php  → <head>, Bootstrap/Google Fonts links, opening <body>
    - includes/navbar-bottom.php → mobile bottom nav / desktop top nav
    - includes/footer.php  → closing tags, Bootstrap JS bundle
- Shared stylesheet: assets/css/style.css for brand overrides (colors, radius, fonts)
  layered on top of Bootstrap defaults (do not fork Bootstrap itself)
- Use PHP session (`session_start()`) for cart, logged-in user, and multi-step forms
  (signup → OTP → new password) even in the front-end-only version, as placeholders
  for future backend wiring (e.g. `$_SESSION['cart']`, `$_SESSION['user']`)

RESPONSIVE RULES
- Mobile-first. Design should look like a native iOS app on screens < 576px
  (single column, full-width cards, bottom nav visible)
- On md (≥768px) and lg (≥992px): center the "phone" content in a max-width
  column (e.g. 480px) OR expand into a 2–3 column dashboard/grid layout for
  browse/listing pages (Home, Desserts, Latest Offers) — use Bootstrap's
  `row-cols-1 row-cols-md-2 row-cols-lg-3` grid utilities
- On lg/xl, swap the fixed bottom nav for a persistent left sidebar or top navbar
- All forms, cards, and images must use Bootstrap responsive utility classes
  (`img-fluid`, `container-fluid`/`container`, `d-flex`, `gap-*`, etc.)
- Test both a narrow (375px) and wide (1440px) viewport mentally before finalizing
```

---

## A. Splash & Onboarding

### 1. `splash.php` — Splash Screen
```
Create splash.php: a centered full-height screen (100vh, flex column, center-aligned)
on a white background with a faint, repeating light-gray line-art food pattern behind
it (pizza slice, drink, utensils outlines — implement as a subtle background-image or
SVG pattern at low opacity). Center the The Black Perch monkey-mascot logo above the
wordmark "The Black Perch" in orange bold text with a small "FOOD DELIVERY" tagline below
in gray uppercase letters, small letter-spacing. No buttons — this is an auto-redirect
splash (meta refresh or JS setTimeout to welcome.php after 2s). Fully centered and
responsive at any viewport size.
```

### 2. `welcome.php` — Welcome / Auth Choice
```
Create welcome.php: same layout as splash but the top ~55% of the screen is a solid
orange (#F97316) rounded-bottom hero panel containing a light circular pattern
background, with the white monkey-mascot logo + "The Black Perch" wordmark centered
inside it. Below the hero panel (on white background): a heading "Discover the best
foods from over 1,000 restaurants and fast delivery to your doorstep" centered, gray
text. Below that, two full-width pill buttons stacked: solid orange "Login" button
and an outline orange "Create an Account" button. Responsive: on desktop, cap the
whole card at max-width 480px and center it horizontally with vertical shadow/border
to look like a phone card on a light gray page background.
```

### 3. `onboard-find-food.php` — Onboarding Slide 1
```
Create onboard-find-food.php: top ~60% shows a large flat-illustration graphic
(bag of food with clock icon, decorative leaves/stars) centered. Below it: bold
heading "Find Food You Love", a gray subtext "Discover the best foods from over
1,000 restaurants and fast delivery to your doorstep", a full-width orange pill
"Next" button, and a thin horizontal "home indicator" bar at the very bottom
(decorative, like iOS). Add small dot-carousel indicators (3 dots) above the
heading to show onboarding progress (dot 1 active). Link Next to
onboard-fast-delivery.php.
```

### 4. `onboard-fast-delivery.php` — Onboarding Slide 2
```
Same template as onboard-find-food.php but swap illustration for a delivery-rider
on a scooter graphic, heading "Fast Delivery", subtext "Fast food delivery to your
home, office wherever you are", dot indicator 2 active, Next button links to
onboard-live-tracking.php.
```

### 5. `onboard-live-tracking.php` — Onboarding Slide 3
```
Same template again, illustration of a hand holding a phone with a pizza/live map
pin graphic, heading "Live Tracking", subtext "Real time tracking of your food on
the app once you've placed the order", dot indicator 3 active, Next button links
to login.php (end of onboarding).
```

---

## B. Authentication

### 6. `login.php`
```
Create login.php: centered card (max-width 480px on all breakpoints), heading
"Login" with subtext "Add your details to login". Bootstrap form with floating
or stacked labels: Email input, Password input (with show/hide toggle icon),
right-aligned small "Forgot password?" link under the password field, a solid
orange full-width pill "Login" submit button, a divider labeled "or Login With",
two full-width secondary buttons — blue "Login with Facebook" (bi-facebook icon)
and a light/white bordered "Login with Google" (bi-google icon) — and a centered
bottom line "Don't have an account? Sign Up" where "Sign Up" links to signup.php
and is orange/bold. Form action posts to auth/login-process.php using PHP
session on success.
```

### 7. `signup.php`
```
Create signup.php: same card layout as login. Heading "Sign Up", subtext "Add
your details to sign up". Stacked inputs: Name, Email, Mobile No, Address,
Password, Confirm Password. Full-width orange pill "Sign Up" button. Bottom
line "Already have an account? Login" linking to login.php. Form posts to
auth/signup-process.php, then redirects to otp-verify.php storing the pending
user in $_SESSION.
```

### 8. `reset-password.php`
```
Create reset-password.php: centered card, heading "Reset Password", subtext
"Please enter your email to receive a link to create new password via email".
Single Email input, full-width orange pill "Send" button. Posts to
auth/reset-request.php, redirects to otp-verify.php.
```

### 9. `otp-verify.php`
```
Create otp-verify.php: centered card, heading "We have sent an OTP to your
Mobile", subtext "Please check your mobile number 07********* and continue to
reset your password". Four separate square OTP input boxes in a centered flex
row (auto-advance focus via small inline JS), full-width orange pill "Next"
button, and a centered "Didn't Receive? Click Here" resend link. Posts to
auth/otp-verify-process.php then redirects to new-password.php.
```

### 10. `new-password.php`
```
Create new-password.php: centered card, heading "New Password", subtext
"Please enter your email to receive a link to create new password via email"
(kept from kit copy), two inputs — New Password, Confirm Password — and a
full-width orange pill "Next" button. Posts to auth/new-password-process.php
then redirects to login.php with a success toast/alert.
```

---

## C. Home & Browse

### 11. `home.php` — Main Dashboard
```
Create home.php: top bar with a greeting "Good morning, Akila!" (pull display
name from $_SESSION['user']['name']) and small subtext "Delivering to" + a
location dropdown ("Current Location" with chevron), plus a cart icon top-right
with a badge count. Below: a rounded search input "Search food" with a search
icon. Below that: a horizontally-scrollable row of category pill/icon cards
(Offers, Sri Lankan, Italian, Indian, ...) using Bootstrap's d-flex + overflow-
auto for a native swipeable feel. Then a "Popular Restaurants" section header
with a "View all" link, followed by a vertical list of restaurant cards (image,
name, star rating + review count, cuisine tags, delivery time). On md+ viewports,
switch the restaurant list to a responsive grid (row-cols-2/row-cols-lg-3) of
cards instead of a stacked list. Include the shared bottom nav partial.
```

### 12. `menu-categories.php` — Slide-out Category Menu
```
Create menu-categories.php (or an off-canvas partial included on home.php):
use Bootstrap's Offcanvas component sliding from the left containing a vertical
list of categories, each with a circular icon thumbnail, category name, and
item count subtext (e.g. "Food · 140 items", "Beverages · 40 items",
"Desserts · 55 items", "Promotions · 25 items"). Highlight the active category
with an orange left border/background tint. Each item links to
category.php?type=<slug>.
```

### 13. `category.php` — Category Listing (e.g. Desserts)
```
Create category.php: top app bar with a back arrow, category title (from
?type= query param, e.g. "Desserts"), and a cart icon. Below: a search input.
Below that: a vertical list (grid on md+) of food item cards, each with a
square thumbnail image on the left, item name, "by <Restaurant Name>" subtext,
and category tag on the right; whole card clickable to product.php?id=<id>.
Include bottom nav partial.
```

### 14. `product.php` — Product Detail
```
Create product.php: large edge-to-edge food photo at the top with a floating
circular back button (top-left) and favorite/heart icon button (top-right)
overlaid on the image using absolute positioning within a position-relative
wrapper — fully responsive so the image scales with viewport width (img-fluid,
object-fit: cover, fixed aspect ratio). Below the image: item name + star
rating on one line, price (e.g. "Rs. 750") right-aligned in orange bold.
"Description" section with lorem body text. "Customize Your Order" section
with two Bootstrap select dropdowns: "Select the size of portion" and "Select
the ingredients". A quantity stepper (−, number, +) using button-group. Sticky
bottom bar (fixed on mobile, static on desktop) showing "Total Price" + amount
on the left and a solid orange "Add to Cart" pill button on the right, which
posts to cart/add.php and updates $_SESSION['cart'].
```

### 15. `offers.php` — Latest Offers
```
Create offers.php: top app bar "Latest Offers" with back arrow, subtext "Find
discounts, offers special meals and more!", a full-width orange "Check Offers"
button/banner at top, followed by a vertical list (grid on md+) of restaurant/
offer cards with image, name, rating, and cuisine tag — same card component as
home.php's restaurant list for consistency. Include bottom nav partial.
```

---

## D. Account & Profile

### 16. `profile.php`
```
Create profile.php: top app bar "Profile" with a cart icon top-right. Centered
circular profile photo with an edit/camera badge icon, greeting "Hi there,
Emilia! Sign Out" (Sign Out as a small link posting to auth/logout.php). Below:
a form with stacked read/write inputs — Name, Email, Address, Password,
Confirm Password (pre-filled from $_SESSION['user'] via PHP) — and a full-width
orange pill "Save" button posting to profile/update.php. Include bottom nav
partial.
```

### 17. `more.php` — Settings / More Menu
```
Create more.php: top app bar "More". Vertical list of nav rows, each a
Bootstrap list-group-item with a left icon, label, and right chevron:
"Payment Details", "My Orders", "Notifications" (with a small unread orange
badge), "Inbox", "About Us". Each row links to its respective page
(payment-details.php, my-orders.php, notifications.php, inbox.php, about.php).
Include bottom nav partial.
```

### 18. `payment-details.php`
```
Create payment-details.php: top app bar "Payment Details" with back arrow,
subtext "Customize your payment method". List of saved methods: "Cash/Card on
delivery" (with a green check icon), a row showing a Visa card ending in
"2187" logo + label "Remove Card" link. "Other Methods" section header. Below:
an outline orange full-width button "+ Add Another Credit/Debit Card" linking
to add-card.php.
```

### 19. `add-card.php`
```
Create add-card.php: top app bar "Payment Details" (or "Add Card") with back
arrow and close (×) icon, subtext "Customize your payment method". Modal-style
or full-page card form: Card Number input, Expiry (MM) and (YY) two-up inputs,
Security Code input, First Name and Last Name inputs, small helper text "You
can remove this card at any time", full-width orange pill "+ Add Card" button
posting to payment/add-card-process.php.
```

### 20. `about.php`
```
Create about.php: top app bar "About Us" with back arrow. Simple content page
with 2–3 paragraphs of body copy (headings optional), constrained to a
readable max-width column and comfortable line-height, consistent header/
bottom-nav partials.
```

### 21. `inbox.php`
```
Create inbox.php: top app bar "Inbox" with back arrow and cart icon. Vertical
list of message cards, each with a small icon/avatar, bold title "MealMonkey
Promotions", 2-line preview body text, and a timestamp/date in the corner
(e.g. "25 Aug 2020"). Repeat card style for each message; include bottom nav
partial.
```

### 22. `notifications.php`
```
Create notifications.php: top app bar "Notifications" with back arrow. Vertical
timeline-style list of notification items, each with a bold title ("Your order
has been picked up", "Your order has been delivered"), a gray body line, and a
relative timestamp ("2 days ago", "25 Aug 2020") right-aligned or below.
Include bottom nav partial.
```

---

## E. Orders & Checkout

### 23. `my-order.php` — Cart / Order Summary
```
Create my-order.php: top app bar "My Order" with back arrow. Restaurant header
row (thumbnail, name, rating, cuisine). Vertical list of ordered items, each
row showing quantity× name on the left and price on the right (e.g. "Beef
Burger x1 — $16"), with a small "+ Add Notes" link. Divider, then a summary
block: "Delivery Instructions" input, "Sub Total", "Delivery Cost", bold
"Total" row, and a full-width orange pill "Checkout" button linking to
checkout.php. Pull cart items from $_SESSION['cart'] via PHP loop.
```

### 24. `checkout.php`
```
Create checkout.php: top app bar "Checkout" with back arrow. Sections as
Bootstrap cards: "Delivery address" showing the saved address text + a
"Change" link (to change-address.php); "Payment method" showing selected
card/cash option + "+ Add Card" link (to add-card.php); an order line-item
summary identical in style to my-order.php (Sub Total, Delivery Cost,
Discount, bold Total). Full-width orange pill "Send Order" button posting to
order/place-order.php, which redirects to order-confirmation.php on success.
```

### 25. `change-address.php`
```
Create change-address.php: top app bar "Change Address" with back arrow. An
embedded map area (use a static map image or an embeddable map iframe/API
placeholder) showing a pin and a floating "Your Current Location" label card
with a target/locate icon. Below the map: a search input "Search address" and
a list of saved place rows (e.g. "Met Foodmarkets" with a bookmark icon) each
selectable, plus a bottom link/button "Choose a saved place". Selecting an
address posts back to checkout.php.
```

### 26. `order-confirmation.php` — "Thank You" Screen
```
Create order-confirmation.php: centered success state — a decorative
illustration (gift/checklist graphic with a green checkmark badge), bold
heading "Thank You!", subtext "For your order — your order is being processed
and we will let you know once it's picked from the outlet. Check the status of
your order.", full-width solid orange pill "Track My Order" button (links to
order-tracking.php / my-order.php), and a secondary text/link button
"Back To Home" linking to home.php.
```

### 27. (bonus) `order-tracking.php` — Live Tracking
```
Create order-tracking.php: full-bleed map background (static image or map
embed placeholder) showing a delivery route with a rider icon, with a
draggable-looking bottom sheet card (Bootstrap offcanvas/fixed-bottom card)
showing rider name/photo, ETA, a progress stepper (Preparing → Picked Up →
On the way → Delivered), and a "Call Rider" icon button. Responsive: on
desktop, show the bottom sheet as a fixed right-hand sidebar next to the map
instead of an overlay.
```

---

## Suggested File/Folder Structure

```
/meal-monkey
  /assets
    /css/style.css
    /img/...
  /includes
    header.php
    footer.php
    navbar-bottom.php
  /auth
    login-process.php, signup-process.php, otp-verify-process.php, ...
  /cart
    add.php, update.php, remove.php
  /order
    place-order.php
  splash.php
  welcome.php
  onboard-find-food.php
  onboard-fast-delivery.php
  onboard-live-tracking.php
  login.php
  signup.php
  reset-password.php
  otp-verify.php
  new-password.php
  home.php
  category.php
  product.php
  offers.php
  profile.php
  more.php
  payment-details.php
  add-card.php
  about.php
  inbox.php
  notifications.php
  my-order.php
  checkout.php
  change-address.php
  order-confirmation.php
  order-tracking.php
```

---

### How to use this doc
1. Paste the **Global Design System Prompt** into your AI coding tool / share with your dev once, so it's in context.
2. Paste each **Screen Prompt** one at a time (or batch a whole section, e.g. all of "Authentication") to generate that `.php` file.
3. Ask for `includes/header.php`, `includes/footer.php`, and `includes/navbar-bottom.php` first, since every screen prompt assumes they exist and will `include` them.
