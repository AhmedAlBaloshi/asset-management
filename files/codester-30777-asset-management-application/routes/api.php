<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Company
    Route::post('companies/media', 'CompanyApiController@storeMedia')->name('companies.storeMedia');
    Route::apiResource('companies', 'CompanyApiController');

    // Team
    Route::apiResource('teams', 'TeamApiController');

    // Asset Category
    Route::apiResource('asset-categories', 'AssetCategoryApiController');

    // Asset Location
    Route::apiResource('asset-locations', 'AssetLocationApiController');

    // Asset Status
    Route::apiResource('asset-statuses', 'AssetStatusApiController');

    // Asset
    Route::post('assets/media', 'AssetApiController@storeMedia')->name('assets.storeMedia');
    Route::apiResource('assets', 'AssetApiController');

    // Assets History
    Route::apiResource('assets-histories', 'AssetsHistoryApiController', ['except' => ['store', 'show', 'update', 'destroy']]);

    // License Management
    Route::post('license-managements/media', 'LicenseManagementApiController@storeMedia')->name('license-managements.storeMedia');
    Route::apiResource('license-managements', 'LicenseManagementApiController');

    // Brands
    Route::apiResource('brands', 'BrandsApiController');

    // Supplier
    Route::post('suppliers/media', 'SupplierApiController@storeMedia')->name('suppliers.storeMedia');
    Route::apiResource('suppliers', 'SupplierApiController');
});
