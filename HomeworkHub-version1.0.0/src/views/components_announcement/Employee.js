import {useContext, useState, useEffect} from 'react';
import {EmployeeContext} from '../contexts_test/EmployeeContext';
import { Modal, Button, OverlayTrigger, Tooltip } from 'react-bootstrap';
import EditForm from './EditForm'



const Employee = (props) => {

    const [show, setShow] = useState(false);
    
    const handleShow = () => setShow(true);
    const handleClose = () => setShow(false);

    useEffect(() => {
        handleClose()
    }, [props.employee])

    return (
        <>
            <td>{props.employee.classroomid}</td> 
            <td>{props.employee.name}</td>
            <td>{props.employee.description}</td>
            <td>{props.employee.duedate}</td>
            <td>
                <OverlayTrigger
                    overlay={
                        <Tooltip id={`tooltip-top`}>
                            Edit Tests
                        </Tooltip>
                    }>
                    <button onClick={handleShow}  className="btn text-warning btn-act" data-toggle="modal">Edit</button>
                </OverlayTrigger>
                <OverlayTrigger
                    overlay={
                        <Tooltip id={`tooltip-top`}>
                            Delete Tests
                        </Tooltip>
                    }>
                    <button onClick={() => props.deleteAnnouncement(props.employee.announcementid)}  type="submit" className="btn text-danger btn-act" data-toggle="modal">Delete</button>
                </OverlayTrigger>
                
                
            </td>

            <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
            <Modal.Title>
                Edit Announcements  
            </Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <EditForm theEmployee={props.employee} />
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

export default Employee;