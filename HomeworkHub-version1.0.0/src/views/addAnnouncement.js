import React from "react";
import axios from "axios";
import EmployeeList from './components_announcement/EmployeeList';
import "./App.css";

class addAnnouncement extends React.Component {

    constructor(props) {
      super(props);
      this.state = {
        username: localStorage.getItem("username"),
        announcements: [],
        today: new Date()
      }

      this.deleteAnnouncement = this.deleteAnnouncement.bind(this);
      this.addAnnouncement = this.addAnnouncement.bind(this);
      this.getAnnouncements = this.getAnnouncements.bind(this);

      this.getAnnouncements();
    }

    getTodaysDate() {
      return this.state.today.getFullYear() + '-' + (this.state.today.getMonth() + 1) + '-' + this.state.today.getDate();
    }

    getAnnouncements() {
      const url = "/HomeworkHub/backend/get_teacher_event_list_for_all_classrooms.php";
      let formData = new FormData();
      let data = '{"username":"' + this.state.username + '", "type":"announcement"}';
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        this.setState({announcements: [...res]});
     })
     .catch(err=>console.log(err.response, err.request));
    }

    addAnnouncement(id, name, desc, date) {
      //USE Date() AND PASS IN CURRENT DATE!
      var today = this.getTodaysDate();
      const url = "/HomeworkHub/backend/create_event.php";
      let formData = new FormData();
      let data = '{"type":"announcement", "name":"' + name + '", "description":"' + desc + '", "duedate":"' + today + '", "classroomid":"' + id + '"}';
      formData.set("formData", data);
    
      axios.post(url, formData)
      .then(response => {
         var res = response["data"];
      })
      .catch(err=>console.log(err));
      this.getAnnouncements();
    }

    deleteAnnouncement(announcementid) {
      const url = "/HomeworkHub/backend/delete_event.php";
      let formData = new FormData();
      let data = '{"eventid":"' + announcementid + '", "type":"announcement"}';
      formData.append("formData", data);
      axios.post(url, formData)
      .then(response => {
        var res = response["data"];
        console.log(res);
     })
     .catch(err=>console.log(err.response, err.request));
     this.getAnnouncements();
    }

    updateAnnouncement() {
      //TODO
    }
  
    render() {
      return (
        <div className="container-xl">
          <div className="table-responsive">
            <div className="table-wrapper">
                <EmployeeList announcements={this.state.announcements} addAnnouncement={this.addAnnouncement} deleteAnnouncement={this.deleteAnnouncement} updateAnnouncement={this.updateAnnouncement}/>
            </div>
          </div>
        </div>
      );
}
}

export default addAnnouncement;