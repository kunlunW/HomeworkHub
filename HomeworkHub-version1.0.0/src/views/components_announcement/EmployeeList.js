import { Modal, Button, Alert} from 'react-bootstrap';
import {useContext, useEffect, useState } from 'react';
import {EmployeeContext} from '../contexts_test/EmployeeContext';
import Employee from './Employee';
import AddForm from './AddForm';
import Pagination from './Pagination';

const EmployeeList = (props) => {

    var sortedEmployees = props.announcements;

    const [showAlert, setShowAlert] = useState(false);

    const [show, setShow] = useState(false);
    
    const handleShow = () => setShow(true);
    const handleClose = () => setShow(false);

    const [currentPage, setCurrentPage] = useState(1);
    const [employeesPerPage] = useState(10)

    const handleShowAlert = () => {
        setShowAlert(true);
        setTimeout(()=> {
            setShowAlert(false);
        }, 2000)
    }

    useEffect(() => {
        handleClose();

        return () => {
            handleShowAlert();
        }
    }, [sortedEmployees])

    const indexOfLastEmployee = currentPage * employeesPerPage;
    const indexOfFirstEmployee = indexOfLastEmployee - employeesPerPage;
    const currentEmployees = sortedEmployees.slice(indexOfFirstEmployee, indexOfLastEmployee);
    const totalPagesNum = Math.ceil(sortedEmployees.length / employeesPerPage);


    return (
    <>
    <div className="table-title2">
        <div className="row">
            <div className="col-sm-6">
                <h2>Manage<b> Announcements</b></h2>
            </div>
            <div className="col-sm-6">
                <Button onClick={handleShow} className="btn btn-success" data-toggle="modal"> <span>Add New Announcements</span></Button>					
            </div>
        </div>
    </div>

    <Alert show={showAlert} variant="success">
        Announcement Info Updated Succefully!
    </Alert>

    <table className="table table-striped table-hover">
        <thead>
            <tr>
                <th>Class ID</th>
                <th>Name</th>
                <th>Desc</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

                {
                  currentEmployees.map(employee => (
                      <tr key={employee.id}>
                        <Employee employee={employee} deleteAnnouncement={props.deleteAnnouncement}/>
                    </tr>
                  ))  
                }
                

        </tbody>
    </table>

    <Pagination pages = {totalPagesNum}
                setCurrentPage={setCurrentPage}
                currentEmployees ={currentEmployees}
                sortedEmployees = {sortedEmployees} />

    <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
            <Modal.Title>
                Add Announcement
            </Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <AddForm addAnnouncement={props.addAnnouncement}/>
        </Modal.Body>
        <Modal.Footer>
                <Button variant="secondary" onClick={handleClose}>
                    Close
                </Button>
        </Modal.Footer>
    </Modal>
    </>
    )
}

export default EmployeeList;