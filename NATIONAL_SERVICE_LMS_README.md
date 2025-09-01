# National Service LMS (Learning Management System)

## Overview
The National Service LMS is a comprehensive system designed to manage the entire lifecycle of National Service applications, from initial submission through training and deployment. This system provides super administrators with complete oversight and control over the National Service program.

## System Architecture

### Database Structure
The system uses the following main tables:
- `students` - Core student information and application status
- `student_profiles` - Detailed student profile information
- `addresses` - Student address information (permanent and present)
- `parent_details` - Parent/guardian information
- `student_documents` - Uploaded documents
- `training_batches` - Training batch management
- `student_training_enrollments` - Student training enrollment tracking
- `interviews` - Interview scheduling and results
- `deployments` - Post-graduation deployment tracking
- `certificate_programs` - Additional certification programs
- `student_certificates` - Student certificate tracking

### Key Features

#### 1. Applicant Screening & Interview Process
- **Total Applications**: View all submitted applications
- **Pending Review**: Applications awaiting initial review
- **Approved for Interview**: Applications approved for interview stage
- **Interview Scheduled**: Interviews that have been scheduled
- **Interview Completed**: Completed interviews with results
- **Application Rejected**: Rejected applications with reasons

#### 2. National Service Training Management
- **Active Batches**: Currently running training batches
- **Students Not Reachable**: Students who cannot be contacted
- **Graduated from Training**: Students who completed training
- **Awaiting Training**: Students approved but not yet enrolled
- **Currently in Training**: Students actively participating in training
- **Training Terminated**: Students whose training was terminated

#### 3. Post Graduation Deployment
- **Deployed to MNDF**: Students deployed to Maldives National Defence Force
- **Deployed to Police**: Students deployed to Police Service
- **Other Units**: Students deployed to other government units
- **Certificate Programs**: Available additional certification programs
- **Under Age 18**: Students who are under the legal age requirement

#### 4. Control Center
- **Active Users**: Total active system users
- **Active Students**: Total approved and active students

## Access Points

### Super Admin Dashboard
- **URL**: `/national-service-lms/dashboard`
- **Access**: Super Admin users only
- **Features**: Complete overview of all system metrics and recent activities

### Student Management
- **URL**: `/national-service-lms/students`
- **Features**: 
  - View all students with filtering options
  - Update application stages
  - View detailed student information
  - Manage student status

### Training Batches
- **URL**: `/national-service-lms/training/batches`
- **Features**:
  - Create new training batches
  - Manage batch capacity and dates
  - Track enrollment numbers

### Interviews
- **URL**: `/national-service-lms/interviews`
- **Features**:
  - Schedule interviews
  - Update interview results
  - Track interview status

### Deployments
- **URL**: `/national-service-lms/deployments`
- **Features**:
  - Create new deployments
  - Assign students to units
  - Track deployment status

### Reports
- **URL**: `/national-service-lms/reports`
- **Features**:
  - Monthly application statistics
  - Application stage distribution
  - Deployment unit statistics

## Student Portal

### Student Login
- **URL**: `/student/login`
- **Features**: Secure student authentication

### Student Dashboard
- **URL**: `/student/dashboard`
- **Features**: Student overview and navigation

### Profile Management
- **URL**: `/student/profile`
- **Features**: Complete profile information submission

### Document Upload
- **URL**: `/student/documents`
- **Features**: Upload required documents

## Application Workflow

### 1. Student Registration
1. Student creates account at `/student/register`
2. Student logs in at `/student/login`
3. Student completes profile information
4. Student uploads required documents
5. Application is submitted for review

### 2. Application Review Process
1. **Pending**: Initial application submitted
2. **Under Review**: Application being reviewed by admin
3. **Approved for Interview**: Application approved, interview scheduled
4. **Interview Scheduled**: Interview date and time set
5. **Interview Completed**: Interview conducted with results
6. **Approved**: Final approval for training
7. **Rejected**: Application rejected with reasons

### 3. Training Process
1. Approved students are enrolled in training batches
2. Training progress is tracked
3. Students can be marked as unreachable if needed
4. Training completion is recorded

### 4. Deployment Process
1. Graduated students are assigned to units
2. Deployment details are recorded
3. Ongoing status tracking

## Technical Implementation

### Controllers
- `NationalServiceLMSController` - Main controller for all LMS functionality
- `StudentController` - Student-specific operations
- `AuthController` - Student authentication

### Models
- All models include proper relationships and validation
- Models support soft deletes where appropriate
- Comprehensive fillable fields for security

### Views
- Responsive design using Bootstrap
- Modern UI with intuitive navigation
- Consistent styling across all pages

### Security
- Middleware protection for all admin routes
- Super admin role verification
- CSRF protection on all forms
- Input validation and sanitization

## Installation & Setup

### 1. Database Migrations
```bash
php artisan migrate
```

### 2. Seed Sample Data (Optional)
```bash
php artisan db:seed --class=NationalServiceLMSSeeder
```

### 3. Access Control
- Ensure user has 'super admin' type to access LMS
- All routes are protected by auth middleware

## Usage Examples

### Creating a Training Batch
1. Navigate to Training Batches
2. Click "Create New Batch"
3. Fill in batch details (name, code, dates, capacity)
4. Submit to create the batch

### Scheduling an Interview
1. Go to Students list
2. Find student approved for interview
3. Click "Schedule Interview"
4. Set date, time, and interviewer
5. Interview is automatically scheduled

### Updating Application Stage
1. View student details
2. Click "Update Stage"
3. Select new stage from dropdown
4. Add rejection reason if applicable
5. Submit to update status

## Customization

### Adding New Application Stages
1. Update the `application_stage` enum in migrations
2. Add corresponding status badges in views
3. Update controller validation rules

### Adding New Deployment Units
1. Update the `unit` enum in migrations
2. Add unit options in deployment forms
3. Update dashboard statistics

### Adding New Document Types
1. Update document type validation in controllers
2. Add type options in document upload forms
3. Update document display logic

## Support & Maintenance

### Regular Tasks
- Monitor application statistics
- Review pending applications
- Update training batch statuses
- Track deployment progress

### Troubleshooting
- Check database connections
- Verify user permissions
- Review application logs
- Ensure all migrations are run

## Future Enhancements

### Planned Features
- Email notifications for status changes
- Advanced reporting and analytics
- Mobile application support
- Integration with external systems
- Automated workflow triggers

### Scalability Considerations
- Database indexing for large datasets
- Caching for frequently accessed data
- API endpoints for external integrations
- Multi-tenant support if needed

## Contact & Support

For technical support or feature requests, please contact the development team.

---

**Version**: 1.0.0  
**Last Updated**: August 2025  
**Compatibility**: Laravel 11.x, PHP 8.2+
