const searchBar = document.querySelector(".search input"),
  searchIcon = document.querySelector(".search button"),
  usersList = document.querySelector(".users-list"),
  addUsersBtn = document.querySelector(".add-users-btn");

let selectedUsers = []; // Array to store selected users

// Toggle search bar visibility
searchIcon.onclick = () => {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

// Handle search functionality
searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.responseText;
        usersList.innerHTML = data; // Update the usersList with the received data
        addSelectionListeners(); // Add event listeners for user selection
      }
    }
  }

  xhr.send("searchTerm=" + searchTerm);
}

// Fetch users periodically
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
          addSelectionListeners(); // Add event listeners for user selection
        }
      }
    }
  }
  xhr.send();
}, 500);


// Define variables
const searchBar = document.querySelector(".search input");
const searchIcon = document.querySelector(".search button");
const usersList = document.querySelector(".users-list");
const groupList = document.querySelector(".group-list ul");

let selectedUsers = []; // Array to store selected users

// Toggle search bar visibility
searchIcon.onclick = () => {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

// Handle search functionality
searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.responseText;
        usersList.innerHTML = data; // Update the usersList with the received data
        addSelectionListeners(); // Add event listeners for user selection
      }
    }
  };

  xhr.send("searchTerm=" + searchTerm);
};

// Function to add event listeners for user selection
function addSelectionListeners() {
  const userListItems = document.querySelectorAll('.user');
  userListItems.forEach(userItem => {
    userItem.addEventListener('click', () => {
      toggleSelection(userItem);
    });
  });
}

// Function to toggle user selection
function toggleSelection(userItem) {
  userItem.classList.toggle('selected');
  const userId = userItem.dataset.userId;
  if (selectedUsers.includes(userId)) {
    selectedUsers = selectedUsers.filter(id => id !== userId); // Remove user if already selected
  } else {
    selectedUsers.push(userId); // Add user to selected users
  }
  console.log(selectedUsers); // Display selected users (you can handle this data as needed, like adding them to a group chat)
}

// Function to handle adding selected users to the group chat
const addUsersToGroupChat = () => {
  // Here you can implement the logic to add selected users to the group chat
  console.log('Adding selected users to group chat:', selectedUsers);
  // Reset selected users array after adding them to the group chat
  selectedUsers = [];
};

// Add event listener to the group chat button
const groupChatButton = document.querySelector('.group-chat-button');
groupChatButton.addEventListener('click', addUsersToGroupChat);