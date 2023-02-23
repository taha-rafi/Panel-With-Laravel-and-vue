<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Classes\Common;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\DatabaseBackup\UpdateCommandRequest;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DatabaseBackupController extends ApiBaseController
{
	public function databaseBackups(Request $request)
	{
		$data = $this->allDatabases();

		return ApiResponse::make('Data fetched', $data);
	}

	public function allDatabases()
	{
		$data = [];

		$allFiles = collect(Storage::disk('backup')->listContents('/'))
			->filter(function ($file) {
				return in_array($file['extension'], ['sql']);
			})
			->sortByDesc('timestamp')
			->values()->all();

		foreach ($allFiles as $currentFile) {
			$fileName = $currentFile['path'];
			$item['id'] = substr($fileName, 0, 8);
			$item['name'] = $fileName;
			$size = Common::formatSizeUnits($currentFile['size']);
			$item['size'] = $size;
			$item['url'] = route('api.settings.download-backups.v1', [$item['id']]);

			$data[] = $item;
		}

		return [
			'data' => $data,
			'totals' => sizeof($data),
		];
	}

	public function generateBackups(Request $request)
	{
		if (env('APP_ENV') == 'production') {
			throw new ApiException('Not Allowed In Demo Mode');
		}

		Artisan::call('database:backup');

		$data = $this->allDatabases();

		return ApiResponse::make('Success', $data);
	}

	public function downloadBackups($id)
	{
		if (env('APP_ENV') == 'production') {
			throw new ApiException('Not Allowed In Demo Mode');
		}

		$downloadedFileName = "";

		foreach (Storage::disk('backup')->files('/') as $filename) {
			if (strpos(basename($filename), $id) !== false) {
				$downloadedFileName = basename($filename);
			}
		}

		// $path = storage_path() . '/app/public/backup/' . $downloadedFileName;
		if (Storage::disk('backup')->exists($downloadedFileName)) {
			return Storage::disk('backup')->download($downloadedFileName);
		}
	}

	public function deleteBackup(Request $request)
	{
		$fileName = $request->file_name;

		if (Storage::disk('backup')->exists($fileName)) {
			Storage::disk('backup')->delete($fileName);
		}

		$data = $this->allDatabases();

		return ApiResponse::make('Success', $data);
	}

	public function updateMysqldumpCommand(UpdateCommandRequest $request)
	{
		$company = company();
		$company->mysqldump_command = $request->mysqldump_command;
		$company->save();

		return ApiResponse::make('Success', []);
	}
}
