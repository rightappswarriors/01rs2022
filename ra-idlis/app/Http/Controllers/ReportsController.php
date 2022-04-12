<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AjaxController;
use DB;

class ReportsController extends Controller
{
    //

	public function assessment(Request $request){
		$dataFromDB = AjaxController::forAssessmentHeaders(array(['asmt_title.serv','<>',null],['hfaci_serv_type.hfser_id','LTO']),array('facilitytyp.facid','facilitytyp.facname','hfaci_serv_type.hfser_id', 'x08_ft.id as xid', 'x08_ft.id as xid'));

		return view('employee.reports.assessment', ['servCap' => $dataFromDB]);
	}

	public function assessmentReportEach(Request $request, $type, $apptype){
		$reports = AjaxController::forAssessmentHeaders(array(['asmt_title.serv','<>',null],['facilitytyp.facid',$type],['assessmentStatus',1],['hfaci_serv_type.hfser_id', $apptype]),array('assessmentcombined.assessmentName','assessmentcombined.assessmentSeq','assessmentcombined.headingText'),3);
		if($reports){
			return view('employee/processflow/pfassessmentgeneratedreport',['reports' => $reports]);
		} else {
			back()->with('errRet', ['errAlt'=>'danger', 'errMsg'=>'Assessment Records not found.']);
		}
	}

	public function inspectionPTC(Request $request){
		$dataFromDB = DB::select('SELECT distinct appform.appid, facilityname, hferc_evaluation.revision, appform.hfser_id, appform.rgnid FROM hferc_evaluation join appform on appform.appid = hferc_evaluation.appid join assessmentcombinedduplicateptc on appform.appid = assessmentcombinedduplicateptc.appid join assessmentrecommendation on appform.appid = assessmentrecommendation.appid');
		return view('employee.reports.ptcinspection', ['servCap' => $dataFromDB]);
	}

	public function recommended(Request $request){
		return self::toReturnNotNullEntryField('isRecoForApproval');
	}
	public function approved(Request $request){
		return self::toReturnNotNullEntryField('isApprove');
	}
	public function certificate(Request $request){
		return self::toReturnNotNullEntryField('certificate');
	}

	public static function toReturnNotNullEntryField($field){
		switch ($field) {
			case 'isRecoForApproval':
				$link = 'employee/dashboard/processflow/recommendation/{appid}';
				break;
			
			case 'isApprove':
				$link = 'employee/dashboard/processflow/approval/{appid}';
				break;

			case 'certificate':
				$link = 'client1/certificates/{hfser_id}/{appid}';
				$field = 'isApprove';
				break;
		}

		$Cur_useData = AjaxController::getCurrentUserAllData();

		if($Cur_useData['grpid'] == 'RLO'){
			$urgnid = $Cur_useData['rgnid'];
			$dataFromDB = DB::select("SELECT distinct appform.appid, facilityname, appform.hfser_id, appform.rgnid from appform where `$field` IS NOT NULL && appform.rgnid = '$urgnid' order by appid DESC");
	
		}else{
			$dataFromDB = DB::select("SELECT distinct appform.appid, facilityname, appform.hfser_id, appform.rgnid from appform where `$field` IS NOT NULL order by appid DESC");
	
		}

			return view('employee.reports.recommended', ['servCap' => $dataFromDB, 'link' => $link]);
	}

	
}
