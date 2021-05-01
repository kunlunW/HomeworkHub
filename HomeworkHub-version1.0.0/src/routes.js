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
import addAnnouncement from "views/addAnnouncement.js";
import User from "views/chatroom.js";
import ParentDashboard from "views/ParentDashboard.js";
import ParentUserProfile from "views/ParentUserProfile.js";
import ParentCalendar from "views/ParentCalendar.js";
import ParentViewTest from "views/ParentViewTest.js";
import ParentViewAnnouncement from "views/ParentViewAnnouncement.js";
import ParentViewHomework from "views/ParentViewHomework.js";
import ParentClassroom from "views/ParentClassroom.js";
import ParentJoinClass from "views/ParentJoinClass.js";

const routes = [
  
  //Teacher Portal Routes Start
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
    path: "/announcements",
    name: "View Announcements",
    icon: "nc-icon nc-circle-09",
    component: addAnnouncement,
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
    name: "View Classrooms",
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
  {
    path: "/classroom",
    name: "Classroom",
    icon: "nc-icon nc-circle-09",
    component: Classroom,
    layout: "/admin",
  },
  //Teacher Portal Routes Stop


  //Parent Portal Routes Start
  {
    path: "/dashboard",
    name: "Dashboard",
    icon: "nc-icon nc-circle-09",
    component: ParentDashboard,
    layout: "/parent",
  },
  {
    path: "/user",
    name: "User Profile",
    icon: "nc-icon nc-circle-09",
    component: ParentUserProfile,
    layout: "/parent",
  },
  {
    path: "/calendar",
    name: "Calendar View",
    icon: "nc-icon nc-circle-09",
    component: ParentCalendar,
    layout: "/parent",
  },
  {
    path: "/announcements",
    name: "View Announcements",
    icon: "nc-icon nc-circle-09",
    component: ParentViewAnnouncement,
    layout: "/parent",
  },
  {
    path: "/homework",
    name: "View Homework",
    icon: "nc-icon nc-circle-09",
    component: ParentViewHomework,
    layout: "/parent",
  },
  {
    path: "/tests",
    name: "View Tests",
    icon: "nc-icon nc-circle-09",
    component: ParentViewTest,
    layout: "/parent",
  },
  {
    path: "/classroom",
    name: "View Classroom",
    icon: "nc-icon nc-circle-09",
    component: ParentClassroom,
    layout: "/parent",
  },
  {
    path: "/join",
    name: "Classroom",
    icon: "nc-icon nc-circle-09",
    component: ParentJoinClass,
    layout: "/parent",
  },
  {
    path: "/chatroom",
    name: "Chat Room",
    icon: "nc-icon nc-circle-09",
    component: User,
    layout: "/admin",
  },


];


export default routes;
