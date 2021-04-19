import {useContext, useState, useEffect} from 'react';
import {EmployeeContext} from '../contexts/EmployeeContext';
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
            <td>{props.employee.parentUserName}</td>
            <td>{props.employee.email}</td>
            <td>{props.employee.mobile_no}</td>
            <td>{props.employee.school}</td>
            <td>
                <OverlayTrigger
                    overlay={
                        <Tooltip id={`tooltip-top`}>
                            Edit Student/Parent Information
                        </Tooltip>
                    }>
                    <button onClick={handleShow}  className="btn text-warning btn-act" data-toggle="modal">Edit</button>
                </OverlayTrigger>
                <OverlayTrigger
                    overlay={
                        <Tooltip id={`tooltip-top`}>
                            Delete Student/Parent Information
                        </Tooltip>
                    }>
                    <button onClick={() => props.deleteParent(props.employee.parentUserName)}  className="btn text-danger btn-act" data-toggle="modal">Delete</button>
                </OverlayTrigger>
                
                
            </td>

            <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
            <Modal.Title>
                Edit Student/Parent
            </Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <EditForm theEmployee={employee} />
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