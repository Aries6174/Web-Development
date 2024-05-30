function getCurrentDateTime() {
    const currentDateTime = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
    };
    
    // Get the current time in AM/PM format
    let hour = currentDateTime.getHours();
    const ampm = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12 || 12; // Convert 0 to 12 for 12-hour clock
    
    // Get the current minutes with leading zero if necessary
    const minutes = currentDateTime.getMinutes().toString().padStart(2, '0');
    const formattedDate = currentDateTime.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    const formattedTime = `${hour}:${minutes} ${ampm}`;
    
    return `Today is ${formattedDate}.<br>The current time is ${formattedTime}.`;
}


function generateSID() {
    return Math.floor(100000 + Math.random() * 900000);
}

function displayCurrentDateTime() {
    const currentDateTimeElement = document.getElementById('currentDateTime');
    currentDateTimeElement.innerHTML = getCurrentDateTime();
}

let students = [];
const courseMapping = {
    1: "BA Food Appreciation",
    2: "BA Applied Poetry of the Future",
    3: "BA Uncensored Communications",
    4: "BS Computer Repair Shop",
    5: "BS Video Gaming",
    6: "BS Installing and Downloading"
};


function addStudent(event) {
    event.preventDefault();

    const studentId = generateSID();
    const name = document.getElementById('name').value.trim();
    const age = document.getElementById('age').value.trim();
    const email = document.getElementById('mail').value.trim();
    const courseId = document.getElementById('course').value.trim();

    const courseName = courseMapping[courseId];

    const student = {
        sid: studentId,
        name: name,
        age: age,
        email: email,
        course: courseName
    };
    students.push(student);
    console.log("Student added", student);
    alert("Student added successfully!");
}


function findStudent() {
    const searchId = document.getElementById('sidsearch').value.trim();
    //console.log("Search ID:", searchId);
    const searchIdNumber = parseInt(searchId);
    const foundStudent = students.find(student => student.sid === searchIdNumber);
    const searchResultElement = document.getElementById('searchResult');
    if (foundStudent) {
        searchResultElement.textContent = `Student ID: ${foundStudent.sid}, Name: ${foundStudent.name}, Age: ${foundStudent.age}, Email: ${foundStudent.email}, Course: ${foundStudent.course}`;
    } else {
        searchResultElement.textContent = "Student not found.";
    }
}


function displayAllStudents() {
    const studentListElement = document.getElementById('studentList');
    studentListElement.innerHTML = '';
    students.forEach(student => {
        const listItem = document.createElement('li');
        listItem.textContent = `Student ID: ${student.sid}, Name: ${student.name}, Age: ${student.age}, Email: ${student.email}, Course: ${student.course}`;
        studentListElement.appendChild(listItem);
    });
}

document.getElementById('displayAllButton').addEventListener('click', displayAllStudents);
document.getElementById('searchButton').addEventListener('click', findStudent);
document.getElementById('confirm').addEventListener('click', addStudent);
document.getElementById('show').addEventListener('click', displayCurrentDateTime);
