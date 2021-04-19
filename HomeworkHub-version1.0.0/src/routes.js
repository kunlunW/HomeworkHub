import Dashboard from "views/Dashboard.js";
import UserProfile from "views/UserProfile.js";
import addHW from "views/addHW.js";
import addDue from "views/addDue.js";
import addTest from "views/addTest.js";
import viewStudent from "views/viewStudent.js";
import viewClass from "views/viewClass.js";
import LogIn from "views/LogIn.js";
import Signup from "views/SignUp.js";
import Classroom from "views/Classroom.js";

const routes = [
  
  {
    path: "/dashboard",
    name: "Dashboard",
    icon: "nc-icon nc-circle-09",
    component: Dashboard,
    layout: "/admin",
  },
  {
    path: "/user",
    name: "User Profile",
    icon: "nc-icon nc-circle-09",
    component: UserProfile,
    layout: "/admin",
  },
  {
    path: "/table",
    name: "Calendar View",
    icon: "nc-icon nc-circle-09",
    component: addHW,
    layout: "/admin",
  },
  {
    path: "/maps",
    name: "View Parents",
    icon: "nc-icon nc-circle-09",
    component: viewStudent,
    layout: "/admin",
  },
  {
    path: "/typography",
    name: "View Homework",
    icon: "nc-icon nc-circle-09",
    component: addDue,
    layout: "/admin",
  },
  {
    path: "/icons",
    name: "View Tests",
    icon: "nc-icon nc-circle-09",
    component: addTest,
    layout: "/admin",
  },
  {
    path: "/classrooms",
    name: "View Classroom",
    icon: "nc-icon nc-circle-09",
    component: viewClass,
    layout: "/admin",
  },
  {
    path: "/login",
    name: "Log In",
    icon: "nc-icon nc-circle-09",
    component: LogIn,
    layout: "/welcome",
  },
  {
    path: "/signup",
    name: "Sign Up",
    icon: "nc-icon nc-circle-09",
    component: Signup,
    layout: "/welcome",
  },

  //Might want to change this 
  {
    path: "/classroom",
    name: "Classroom",
    icon: "nc-icon nc-circle-09",
    component: Classroom,
    layout: "/admin",
  },
];


export default routes;
