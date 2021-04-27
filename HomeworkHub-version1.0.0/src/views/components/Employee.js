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
                            Delete Student/Parent Information
                        </Tooltip>
                    }>
                    <button onClick={() => props.deleteParent(props.employee.parentUserName)}  className="btn text-danger btn-act" data-toggle="modal">Delete</button>
                </OverlayTrigger>
                
                
            </td>
        </>
    )
}

export default Employee;