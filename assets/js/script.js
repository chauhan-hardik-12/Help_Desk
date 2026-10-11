// 🚪 Logout handler
function logout(targetUrl) {
  var url = targetUrl || "logout.php";
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = url;
  }
}

// 📋 Complaint Form Client-Side Validation
function complaintsubmit() {
  var nameEl  = document.getElementById("fullName");
  var emailEl = document.getElementById("email");
  var idEl    = document.getElementById("studentId");
  var catEl   = document.getElementById("category");
  var issueEl = document.getElementById("issue");

  var name  = nameEl ? nameEl.value.trim() : "";
  var email = emailEl ? emailEl.value.trim() : "";
  var id    = idEl ? idEl.value.trim() : "";
  var cat   = catEl ? catEl.value : "";
  var issue = issueEl ? issueEl.value.trim() : "";

  // Reset previous error messages
  var errorIds = ["nameError", "emailError", "idError", "catError", "issueError"];
  errorIds.forEach(function(eid) {
    var el = document.getElementById(eid);
    if (el) el.textContent = "";
  });

  var valid = true;
  var firstInvalidEl = null;

  // Name validation
  if (!name) {
    document.getElementById("nameError").textContent = "Please enter your full name.";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = nameEl;
  } else if (name.length < 3) {
    document.getElementById("nameError").textContent = "Name must be at least 3 characters.";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = nameEl;
  }

  // Email validation
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email) {
    document.getElementById("emailError").textContent = "Please enter your email address.";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = emailEl;
  } else if (!emailRegex.test(email)) {
    document.getElementById("emailError").textContent = "Please enter a valid email format (e.g. name@example.com).";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = emailEl;
  }

  // Student ID validation (12 digits)
  if (!id) {
    document.getElementById("idError").textContent = "Please enter your 12-digit Student ID.";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = idEl;
  } else if (!/^\d{12}$/.test(id)) {
    document.getElementById("idError").textContent = "Student ID must be exactly 12 digits (numbers only).";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = idEl;
  }

  // Category validation
  if (!cat) {
    document.getElementById("catError").textContent = "Please select a complaint category.";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = catEl;
  }

  // Issue description validation
  if (!issue) {
    document.getElementById("issueError").textContent = "Please describe the issue you are facing.";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = issueEl;
  } else if (issue.length < 10) {
    document.getElementById("issueError").textContent = "Please provide more details (at least 10 characters).";
    valid = false;
    if (!firstInvalidEl) firstInvalidEl = issueEl;
  }

  if (!valid && firstInvalidEl) {
    firstInvalidEl.focus();
  }

  return valid;
}