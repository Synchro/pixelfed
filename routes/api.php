<?php

use App\Http\Controllers\AdminInviteController;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\V1\TagsController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ComposeController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\FederationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Groups;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\InstanceActorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PixelfedDirectoryController;
use App\Http\Controllers\StatusEditController;
use App\Http\Controllers\Stories;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserAppSettingsController;
use Illuminate\Support\Facades\Route;

$middleware = ['auth:api', 'validemail'];

Route::post('/f/inbox', [FederationController::class, 'sharedInbox']);
Route::post('/users/{username}/inbox', [FederationController::class, 'userInbox']);
Route::get('i/actor', [InstanceActorController::class, 'profile']);
Route::post('i/actor/inbox', [InstanceActorController::class, 'inbox']);
Route::get('i/actor/outbox', [InstanceActorController::class, 'outbox']);
Route::get('/stories/{username}/{id}', [StoryController::class, 'getActivityObject']);

Route::get('.well-known/webfinger', [FederationController::class, 'webfinger'])->name('well-known.webfinger');
Route::get('.well-known/nodeinfo', [FederationController::class, 'nodeinfoWellKnown'])->name('well-known.nodeinfo');
Route::get('.well-known/host-meta', [FederationController::class, 'hostMeta'])->name('well-known.hostMeta');
Route::redirect('.well-known/change-password', '/settings/password');
Route::get('api/nodeinfo/2.0.json', [FederationController::class, 'nodeinfo']);
Route::get('api/service/health-check', [HealthCheckController::class, 'get']);

Route::prefix('api/v0/groups')->middleware($middleware)->group(function () {
    Route::get('config', [Groups\GroupsApiController::class, 'getConfig']);
    Route::post('permission/create', [Groups\CreateGroupsController::class, 'checkCreatePermission']);
    Route::post('create', [Groups\CreateGroupsController::class, 'storeGroup']);

    Route::post('search/invite/friends/send', [Groups\GroupsSearchController::class, 'inviteFriendsToGroup']);
    Route::post('search/invite/friends', [Groups\GroupsSearchController::class, 'searchFriendsToInvite']);
    Route::post('search/global', [Groups\GroupsSearchController::class, 'searchGlobalResults']);
    Route::post('search/lac', [Groups\GroupsSearchController::class, 'searchLocalAutocomplete']);
    Route::post('search/addrec', [Groups\GroupsSearchController::class, 'searchAddRecent']);
    Route::get('search/getrec', [Groups\GroupsSearchController::class, 'searchGetRecent']);
    Route::get('comments', [Groups\GroupsCommentController::class, 'getComments']);
    Route::post('comment', [Groups\GroupsCommentController::class, 'storeComment']);
    Route::post('comment/photo', [Groups\GroupsCommentController::class, 'storeCommentPhoto']);
    Route::post('comment/delete', [Groups\GroupsCommentController::class, 'deleteComment']);
    Route::get('discover/popular', [Groups\GroupsDiscoverController::class, 'getDiscoverPopular']);
    Route::get('discover/new', [Groups\GroupsDiscoverController::class, 'getDiscoverNew']);
    Route::post('delete', [Groups\GroupsMetaController::class, 'deleteGroup']);
    Route::post('status/new', [Groups\GroupsPostController::class, 'storePost']);
    Route::post('status/delete', [Groups\GroupsPostController::class, 'deletePost']);
    Route::post('status/like', [Groups\GroupsPostController::class, 'likePost']);
    Route::post('status/unlike', [Groups\GroupsPostController::class, 'unlikePost']);
    Route::get('topics/list', [Groups\GroupsTopicController::class, 'groupTopics']);
    Route::get('topics/tag', [Groups\GroupsTopicController::class, 'groupTopicTag']);
    Route::get('accounts/{gid}/{pid}', [Groups\GroupsApiController::class, 'getGroupAccount']);
    Route::get('categories/list', [Groups\GroupsApiController::class, 'getGroupCategories']);
    Route::get('category/list', [Groups\GroupsApiController::class, 'getGroupsByCategory']);
    Route::get('self/recommended/list', [Groups\GroupsApiController::class, 'getRecommendedGroups']);
    Route::get('self/list', [Groups\GroupsApiController::class, 'getSelfGroups']);
    Route::get('media/list', [Groups\GroupsPostController::class, 'getGroupMedia']);
    Route::get('members/list', [Groups\GroupsMemberController::class, 'getGroupMembers']);
    Route::get('members/requests', [Groups\GroupsMemberController::class, 'getGroupMemberJoinRequests']);
    Route::post('members/request', [Groups\GroupsMemberController::class, 'handleGroupMemberJoinRequest']);
    Route::get('members/get', [Groups\GroupsMemberController::class, 'getGroupMember']);
    Route::get('member/intersect/common', [Groups\GroupsMemberController::class, 'getGroupMemberCommonIntersections']);
    Route::get('status', [Groups\GroupsPostController::class, 'getStatus']);
    Route::post('like', [GroupController::class, 'likePost']);
    Route::post('comment/like', [Groups\GroupsCommentController::class, 'likePost']);
    Route::post('comment/unlike', [Groups\GroupsCommentController::class, 'unlikePost']);
    Route::get('self/feed', [Groups\GroupsFeedController::class, 'getSelfFeed']);
    Route::get('self/notifications', [Groups\GroupsNotificationsController::class, 'selfGlobalNotifications']);
    Route::get('{id}/user/{pid}/feed', [Groups\GroupsFeedController::class, 'getGroupProfileFeed']);
    Route::get('{id}/feed', [Groups\GroupsFeedController::class, 'getGroupFeed']);
    Route::get('{id}/atabs', [Groups\GroupsAdminController::class, 'getAdminTabs']);
    Route::get('{id}/admin/interactions', [Groups\GroupsAdminController::class, 'getInteractionLogs']);
    Route::get('{id}/admin/blocks', [Groups\GroupsAdminController::class, 'getBlocks']);
    Route::post('{id}/admin/blocks/add', [Groups\GroupsAdminController::class, 'addBlock']);
    Route::post('{id}/admin/blocks/undo', [Groups\GroupsAdminController::class, 'undoBlock']);
    Route::post('{id}/admin/blocks/export', [Groups\GroupsAdminController::class, 'exportBlocks']);
    Route::get('{id}/reports/list', [Groups\GroupsAdminController::class, 'getReportList']);

    Route::get('{id}/members/interaction-limits', [GroupController::class, 'getMemberInteractionLimits']);
    Route::post('{id}/invite/check', [GroupController::class, 'groupMemberInviteCheck']);
    Route::post('{id}/invite/accept', [GroupController::class, 'groupMemberInviteAccept']);
    Route::post('{id}/invite/decline', [GroupController::class, 'groupMemberInviteDecline']);
    Route::post('{id}/members/interaction-limits', [GroupController::class, 'updateMemberInteractionLimits']);
    Route::post('{id}/report/action', [GroupController::class, 'reportAction']);
    Route::post('{id}/report/create', [GroupController::class, 'reportCreate']);
    Route::post('{id}/admin/mbs', [GroupController::class, 'metaBlockSearch']);
    Route::post('{id}/join', [GroupController::class, 'joinGroup']);
    Route::post('{id}/cjr', [GroupController::class, 'cancelJoinRequest']);
    Route::post('{id}/leave', [GroupController::class, 'groupLeave']);
    Route::post('{id}/settings', [GroupController::class, 'updateGroup']);
    Route::get('{id}/likes/{sid}', [GroupController::class, 'showStatusLikes']);
    Route::get('{id}', [GroupController::class, 'getGroup']);
});

Route::prefix('api')->group(function () use ($middleware) {

    Route::prefix('v1')->group(function () use ($middleware) {
        Route::post('apps', [Api\ApiV1Controller::class, 'apps']);
        Route::get('apps/verify_credentials', [Api\ApiV1Controller::class, 'getApp'])->middleware($middleware);
        Route::get('instance', [Api\ApiV1Controller::class, 'instance']);
        Route::get('instance/peers', [Api\ApiV1Controller::class, 'instancePeers']);
        Route::get('bookmarks', [Api\ApiV1Controller::class, 'bookmarks'])->middleware($middleware);

        Route::get('accounts/verify_credentials', [Api\ApiV1Controller::class, 'verifyCredentials'])->middleware($middleware);
        Route::match(['post', 'patch'], 'accounts/update_credentials', [Api\ApiV1Controller::class, 'accountUpdateCredentials'])->middleware($middleware);
        Route::get('accounts/relationships', [Api\ApiV1Controller::class, 'accountRelationshipsById'])->middleware($middleware);
        Route::get('accounts/search', [Api\ApiV1Controller::class, 'accountSearch'])->middleware($middleware);
        Route::get('accounts/{id}/statuses', [Api\ApiV1Controller::class, 'accountStatusesById'])->middleware($middleware);
        Route::get('accounts/{id}/following', [Api\ApiV1Controller::class, 'accountFollowingById'])->middleware($middleware);
        Route::get('accounts/{id}/followers', [Api\ApiV1Controller::class, 'accountFollowersById'])->middleware($middleware);
        Route::post('accounts/{id}/follow', [Api\ApiV1Controller::class, 'accountFollowById'])->middleware($middleware);
        Route::post('accounts/{id}/unfollow', [Api\ApiV1Controller::class, 'accountUnfollowById'])->middleware($middleware);
        Route::post('accounts/{id}/block', [Api\ApiV1Controller::class, 'accountBlockById'])->middleware($middleware);
        Route::post('accounts/{id}/unblock', [Api\ApiV1Controller::class, 'accountUnblockById'])->middleware($middleware);
        Route::post('accounts/{id}/pin', [Api\ApiV1Controller::class, 'accountEndorsements'])->middleware($middleware);
        Route::post('accounts/{id}/unpin', [Api\ApiV1Controller::class, 'accountEndorsements'])->middleware($middleware);
        Route::post('accounts/{id}/mute', [Api\ApiV1Controller::class, 'accountMuteById'])->middleware($middleware);
        Route::post('accounts/{id}/unmute', [Api\ApiV1Controller::class, 'accountUnmuteById'])->middleware($middleware);
        Route::get('accounts/{id}/lists', [Api\ApiV1Controller::class, 'accountListsById'])->middleware($middleware);
        Route::get('lists/{id}/accounts', [Api\ApiV1Controller::class, 'accountListsById'])->middleware($middleware);
        Route::get('accounts/{id}', [Api\ApiV1Controller::class, 'accountById'])->middleware($middleware);

        Route::post('avatar/update', [ApiController::class, 'avatarUpdate'])->middleware($middleware);
        Route::get('blocks', [Api\ApiV1Controller::class, 'accountBlocks'])->middleware($middleware);
        Route::get('conversations', [Api\ApiV1Controller::class, 'conversations'])->middleware($middleware);
        Route::get('custom_emojis', [Api\ApiV1Controller::class, 'customEmojis']);
        Route::get('domain_blocks', [Api\V1\DomainBlockController::class, 'index'])->middleware($middleware);
        Route::post('domain_blocks', [Api\V1\DomainBlockController::class, 'store'])->middleware($middleware);
        Route::delete('domain_blocks', [Api\V1\DomainBlockController::class, 'delete'])->middleware($middleware);
        Route::get('endorsements', [Api\ApiV1Controller::class, 'accountEndorsements'])->middleware($middleware);
        Route::get('favourites', [Api\ApiV1Controller::class, 'accountFavourites'])->middleware($middleware);
        Route::get('filters', [Api\ApiV1Controller::class, 'accountFilters'])->middleware($middleware);
        Route::get('follow_requests', [Api\ApiV1Controller::class, 'accountFollowRequests'])->middleware($middleware);
        Route::post('follow_requests/{id}/authorize', [Api\ApiV1Controller::class, 'accountFollowRequestAccept'])->middleware($middleware);
        Route::post('follow_requests/{id}/reject', [Api\ApiV1Controller::class, 'accountFollowRequestReject'])->middleware($middleware);
        Route::get('lists', [Api\ApiV1Controller::class, 'accountLists'])->middleware($middleware);
        Route::post('media', [Api\ApiV1Controller::class, 'mediaUpload'])->middleware($middleware);
        Route::get('media/{id}', [Api\ApiV1Controller::class, 'mediaGet'])->middleware($middleware);
        Route::put('media/{id}', [Api\ApiV1Controller::class, 'mediaUpdate'])->middleware($middleware);
        Route::get('mutes', [Api\ApiV1Controller::class, 'accountMutes'])->middleware($middleware);
        Route::get('notifications', [Api\ApiV1Controller::class, 'accountNotifications'])->middleware($middleware);
        Route::get('suggestions', [Api\ApiV1Controller::class, 'accountSuggestions'])->middleware($middleware);

        Route::post('statuses/{id}/favourite', [Api\ApiV1Controller::class, 'statusFavouriteById'])->middleware($middleware);
        Route::post('statuses/{id}/unfavourite', [Api\ApiV1Controller::class, 'statusUnfavouriteById'])->middleware($middleware);
        Route::get('statuses/{id}/context', [Api\ApiV1Controller::class, 'statusContext'])->middleware($middleware);
        Route::get('statuses/{id}/card', [Api\ApiV1Controller::class, 'statusCard'])->middleware($middleware);
        Route::get('statuses/{id}/reblogged_by', [Api\ApiV1Controller::class, 'statusRebloggedBy'])->middleware($middleware);
        Route::get('statuses/{id}/favourited_by', [Api\ApiV1Controller::class, 'statusFavouritedBy'])->middleware($middleware);
        Route::post('statuses/{id}/reblog', [Api\ApiV1Controller::class, 'statusShare'])->middleware($middleware);
        Route::post('statuses/{id}/unreblog', [Api\ApiV1Controller::class, 'statusUnshare'])->middleware($middleware);
        Route::post('statuses/{id}/bookmark', [Api\ApiV1Controller::class, 'bookmarkStatus'])->middleware($middleware);
        Route::post('statuses/{id}/unbookmark', [Api\ApiV1Controller::class, 'unbookmarkStatus'])->middleware($middleware);
        Route::delete('statuses/{id}', [Api\ApiV1Controller::class, 'statusDelete'])->middleware($middleware);
        Route::get('statuses/{id}', [Api\ApiV1Controller::class, 'statusById'])->middleware($middleware);
        Route::post('statuses', [Api\ApiV1Controller::class, 'statusCreate'])->middleware($middleware);

        Route::get('timelines/home', [Api\ApiV1Controller::class, 'timelineHome'])->middleware($middleware);
        Route::get('timelines/public', [Api\ApiV1Controller::class, 'timelinePublic'])->middleware($middleware);
        Route::get('timelines/tag/{hashtag}', [Api\ApiV1Controller::class, 'timelineHashtag'])->middleware($middleware);
        Route::get('discover/posts', [Api\ApiV1Controller::class, 'discoverPosts'])->middleware($middleware);

        Route::get('preferences', [Api\ApiV1Controller::class, 'getPreferences'])->middleware($middleware);
        Route::get('trends', [Api\ApiV1Controller::class, 'getTrends'])->middleware($middleware);
        Route::get('announcements', [Api\ApiV1Controller::class, 'getAnnouncements'])->middleware($middleware);
        Route::get('markers', [Api\ApiV1Controller::class, 'getMarkers'])->middleware($middleware);
        Route::post('markers', [Api\ApiV1Controller::class, 'setMarkers'])->middleware($middleware);

        Route::get('followed_tags', [TagsController::class, 'getFollowedTags'])->middleware($middleware);
        Route::post('tags/{id}/follow', [TagsController::class, 'followHashtag'])->middleware($middleware);
        Route::post('tags/{id}/unfollow', [TagsController::class, 'unfollowHashtag'])->middleware($middleware);
        Route::get('tags/{id}/related', [TagsController::class, 'relatedTags'])->middleware($middleware);
        Route::get('tags/{id}', [TagsController::class, 'getHashtag'])->middleware($middleware);

        Route::get('statuses/{id}/history', [StatusEditController::class, 'history'])->middleware($middleware);
        Route::put('statuses/{id}', [StatusEditController::class, 'store'])->middleware($middleware);

        Route::prefix('admin')->group(function () use ($middleware) {
            Route::get('domain_blocks', [Api\V1\Admin\DomainBlocksController::class, 'index'])->middleware($middleware);
            Route::post('domain_blocks', [Api\V1\Admin\DomainBlocksController::class, 'create'])->middleware($middleware);
            Route::get('domain_blocks/{id}', [Api\V1\Admin\DomainBlocksController::class, 'show'])->middleware($middleware);
            Route::put('domain_blocks/{id}', [Api\V1\Admin\DomainBlocksController::class, 'update'])->middleware($middleware);
            Route::delete('domain_blocks/{id}', [Api\V1\Admin\DomainBlocksController::class, 'delete'])->middleware($middleware);
        })->middleware($middleware);
    });

    Route::prefix('v2')->group(function () use ($middleware) {
        Route::get('search', [Api\ApiV2Controller::class, 'search'])->middleware($middleware);
        Route::post('media', [Api\ApiV2Controller::class, 'mediaUploadV2'])->middleware($middleware);
        Route::get('streaming/config', [Api\ApiV2Controller::class, 'getWebsocketConfig']);
        Route::get('instance', [Api\ApiV2Controller::class, 'instance']);
    });

    Route::prefix('v1.1')->group(function () use ($middleware) {
        Route::post('report', [Api\ApiV1Dot1Controller::class, 'report'])->middleware($middleware);

        Route::prefix('accounts')->group(function () use ($middleware) {
            Route::get('timelines/home', [Api\ApiV1Controller::class, 'timelineHome'])->middleware($middleware);
            Route::delete('avatar', [Api\ApiV1Dot1Controller::class, 'deleteAvatar'])->middleware($middleware);
            Route::get('{id}/posts', [Api\ApiV1Dot1Controller::class, 'accountPosts'])->middleware($middleware);
            Route::post('change-password', [Api\ApiV1Dot1Controller::class, 'accountChangePassword'])->middleware($middleware);
            Route::get('login-activity', [Api\ApiV1Dot1Controller::class, 'accountLoginActivity'])->middleware($middleware);
            Route::get('two-factor', [Api\ApiV1Dot1Controller::class, 'accountTwoFactor'])->middleware($middleware);
            Route::get('emails-from-pixelfed', [Api\ApiV1Dot1Controller::class, 'accountEmailsFromPixelfed'])->middleware($middleware);
            Route::get('apps-and-applications', [Api\ApiV1Dot1Controller::class, 'accountApps'])->middleware($middleware);
            Route::get('mutuals/{id}', [Api\ApiV1Dot1Controller::class, 'getMutualAccounts'])->middleware($middleware);
            Route::get('username/{username}', [Api\ApiV1Dot1Controller::class, 'accountUsernameToId'])->middleware($middleware);
        });

        Route::prefix('collections')->group(function () use ($middleware) {
            Route::get('accounts/{id}', [CollectionController::class, 'getUserCollections'])->middleware($middleware);
            Route::get('items/{id}', [CollectionController::class, 'getItems'])->middleware($middleware);
            Route::get('view/{id}', [CollectionController::class, 'getCollection'])->middleware($middleware);
            Route::post('add', [CollectionController::class, 'storeId'])->middleware($middleware);
            Route::post('update/{id}', [CollectionController::class, 'store'])->middleware($middleware);
            Route::delete('delete/{id}', [CollectionController::class, 'delete'])->middleware($middleware);
            Route::post('remove', [CollectionController::class, 'deleteId'])->middleware($middleware);
            Route::get('self', [CollectionController::class, 'getSelfCollections'])->middleware($middleware);
        });

        Route::prefix('direct')->group(function () use ($middleware) {
            Route::get('thread', [DirectMessageController::class, 'thread'])->middleware($middleware);
            Route::post('thread/send', [DirectMessageController::class, 'create'])->middleware($middleware);
            Route::delete('thread/message', [DirectMessageController::class, 'delete'])->middleware($middleware);
            Route::post('thread/mute', [DirectMessageController::class, 'mute'])->middleware($middleware);
            Route::post('thread/unmute', [DirectMessageController::class, 'unmute'])->middleware($middleware);
            Route::post('thread/media', [DirectMessageController::class, 'mediaUpload'])->middleware($middleware);
            Route::post('thread/read', [DirectMessageController::class, 'read'])->middleware($middleware);
            Route::post('lookup', [DirectMessageController::class, 'composeLookup'])->middleware($middleware);
        });

        Route::prefix('archive')->group(function () use ($middleware) {
            Route::post('add/{id}', [Api\ApiV1Dot1Controller::class, 'archive'])->middleware($middleware);
            Route::post('remove/{id}', [Api\ApiV1Dot1Controller::class, 'unarchive'])->middleware($middleware);
            Route::get('list', [Api\ApiV1Dot1Controller::class, 'archivedPosts'])->middleware($middleware);
        });

        Route::prefix('places')->group(function () use ($middleware) {
            Route::get('posts/{id}/{slug}', [Api\ApiV1Dot1Controller::class, 'placesById'])->middleware($middleware);
        });

        Route::prefix('stories')->group(function () use ($middleware) {
            Route::get('carousel', [Stories\StoryApiV1Controller::class, 'carousel'])->middleware($middleware);
            Route::post('add', [Stories\StoryApiV1Controller::class, 'add'])->middleware($middleware);
            Route::post('publish', [Stories\StoryApiV1Controller::class, 'publish'])->middleware($middleware);
            Route::post('seen', [Stories\StoryApiV1Controller::class, 'viewed'])->middleware($middleware);
            Route::post('self-expire/{id}', [Stories\StoryApiV1Controller::class, 'delete'])->middleware($middleware);
            Route::post('comment', [Stories\StoryApiV1Controller::class, 'comment'])->middleware($middleware);
        });

        Route::prefix('compose')->group(function () use ($middleware) {
            Route::get('search/location', [ComposeController::class, 'searchLocation'])->middleware($middleware);
            Route::get('settings', [ComposeController::class, 'composeSettings'])->middleware($middleware);
        });

        Route::prefix('discover')->group(function () use ($middleware) {
            Route::get('accounts/popular', [Api\ApiV1Controller::class, 'discoverAccountsPopular'])->middleware($middleware);
            Route::get('posts/trending', [DiscoverController::class, 'trendingApi'])->middleware($middleware);
            Route::get('posts/hashtags', [DiscoverController::class, 'trendingHashtags'])->middleware($middleware);
            Route::get('posts/network/trending', [DiscoverController::class, 'discoverNetworkTrending'])->middleware($middleware);
        });

        Route::prefix('directory')->group(function () {
            Route::get('listing', [PixelfedDirectoryController::class, 'get']);
        });

        Route::prefix('auth')->group(function () {
            Route::get('iarpfc', [Api\ApiV1Dot1Controller::class, 'inAppRegistrationPreFlightCheck']);
            Route::post('iar', [Api\ApiV1Dot1Controller::class, 'inAppRegistration']);
            Route::post('iarc', [Api\ApiV1Dot1Controller::class, 'inAppRegistrationConfirm']);
            Route::get('iarer', [Api\ApiV1Dot1Controller::class, 'inAppRegistrationEmailRedirect']);

            Route::post('invite/admin/verify', [AdminInviteController::class, 'apiVerifyCheck'])->middleware('throttle:20,120');
            Route::post('invite/admin/uc', [AdminInviteController::class, 'apiUsernameCheck'])->middleware('throttle:20,120');
            Route::post('invite/admin/ec', [AdminInviteController::class, 'apiEmailCheck'])->middleware('throttle:10,1440');
        });

        Route::prefix('expo')->group(function () use ($middleware) {
            Route::get('push-notifications', [Api\ApiV1Dot1Controller::class, 'getExpoPushNotifications'])->middleware($middleware);
            Route::post('push-notifications/update', [Api\ApiV1Dot1Controller::class, 'updateExpoPushNotifications'])->middleware($middleware);
            Route::post('push-notifications/disable', [Api\ApiV1Dot1Controller::class, 'disableExpoPushNotifications'])->middleware($middleware);
        });

        Route::post('status/create', [Api\ApiV1Dot1Controller::class, 'statusCreate'])->middleware($middleware);
    });

    Route::prefix('live')->group(function () {
        // Route::post('create_stream', 'LiveStreamController@createStream')->middleware($middleware);
        // Route::post('stream/edit', 'LiveStreamController@editStream')->middleware($middleware);
        // Route::get('active/list', 'LiveStreamController@getActiveStreams')->middleware($middleware);
        // Route::get('accounts/stream', 'LiveStreamController@getUserStream')->middleware($middleware);
        // Route::get('accounts/stream/guest', 'LiveStreamController@getUserStreamAsGuest');
        // Route::delete('accounts/stream', 'LiveStreamController@deleteStream')->middleware($middleware);
        // Route::get('chat/latest', 'LiveStreamController@getLatestChat')->middleware($middleware);
        // Route::post('chat/message', 'LiveStreamController@addChatComment')->middleware($middleware);
        // Route::post('chat/delete', 'LiveStreamController@deleteChatComment')->middleware($middleware);
        // Route::post('chat/ban-user', 'LiveStreamController@banChatUser')->middleware($middleware);
        // Route::post('chat/pin', 'LiveStreamController@pinChatComment')->middleware($middleware);
        // Route::post('chat/unpin', 'LiveStreamController@unpinChatComment')->middleware($middleware);
        // Route::get('config', 'LiveStreamController@getConfig');
        // Route::post('broadcast/publish', 'LiveStreamController@clientBroadcastPublish')->middleware($middleware);
        // Route::post('broadcast/finish', 'LiveStreamController@clientBroadcastFinish')->middleware($middleware);
    });

    Route::prefix('admin')->group(function () use ($middleware) {
        Route::post('moderate/post/{id}', [Api\ApiV1Dot1Controller::class, 'moderatePost'])->middleware($middleware);
        Route::get('supported', [Api\AdminApiController::class, 'supported'])->middleware($middleware);
        Route::get('stats', [Api\AdminApiController::class, 'getStats'])->middleware($middleware);

        Route::get('autospam/list', [Api\AdminApiController::class, 'autospam'])->middleware($middleware);
        Route::post('autospam/handle', [Api\AdminApiController::class, 'autospamHandle'])->middleware($middleware);
        Route::get('mod-reports/list', [Api\AdminApiController::class, 'modReports'])->middleware($middleware);
        Route::post('mod-reports/handle', [Api\AdminApiController::class, 'modReportHandle'])->middleware($middleware);
        Route::get('config', [Api\AdminApiController::class, 'getConfiguration'])->middleware($middleware);
        Route::post('config/update', [Api\AdminApiController::class, 'updateConfiguration'])->middleware($middleware);
        Route::get('users/list', [Api\AdminApiController::class, 'getUsers'])->middleware($middleware);
        Route::get('users/get', [Api\AdminApiController::class, 'getUser'])->middleware($middleware);
        Route::post('users/action', [Api\AdminApiController::class, 'userAdminAction'])->middleware($middleware);
        Route::get('instances/list', [Api\AdminApiController::class, 'instances'])->middleware($middleware);
        Route::get('instances/get', [Api\AdminApiController::class, 'getInstance'])->middleware($middleware);
        Route::post('instances/moderate', [Api\AdminApiController::class, 'moderateInstance'])->middleware($middleware);
        Route::post('instances/refresh-stats', [Api\AdminApiController::class, 'refreshInstanceStats'])->middleware($middleware);
        Route::get('instance/stats', [Api\AdminApiController::class, 'getAllStats'])->middleware($middleware);
    });

    Route::prefix('landing/v1')->group(function () {
        Route::get('directory', [LandingController::class, 'getDirectoryApi']);
    });

    Route::prefix('pixelfed')->group(function () use ($middleware) {
        Route::prefix('v1')->group(function () use ($middleware) {
            Route::post('report', [Api\ApiV1Dot1Controller::class, 'report'])->middleware($middleware);

            Route::prefix('accounts')->group(function () use ($middleware) {
                Route::get('timelines/home', [Api\ApiV1Controller::class, 'timelineHome'])->middleware($middleware);
                Route::delete('avatar', [Api\ApiV1Dot1Controller::class, 'deleteAvatar'])->middleware($middleware);
                Route::get('{id}/posts', [Api\ApiV1Dot1Controller::class, 'accountPosts'])->middleware($middleware);
                Route::post('change-password', [Api\ApiV1Dot1Controller::class, 'accountChangePassword'])->middleware($middleware);
                Route::get('login-activity', [Api\ApiV1Dot1Controller::class, 'accountLoginActivity'])->middleware($middleware);
                Route::get('two-factor', [Api\ApiV1Dot1Controller::class, 'accountTwoFactor'])->middleware($middleware);
                Route::get('emails-from-pixelfed', [Api\ApiV1Dot1Controller::class, 'accountEmailsFromPixelfed'])->middleware($middleware);
                Route::get('apps-and-applications', [Api\ApiV1Dot1Controller::class, 'accountApps'])->middleware($middleware);
            });

            Route::prefix('archive')->group(function () use ($middleware) {
                Route::post('add/{id}', [Api\ApiV1Dot1Controller::class, 'archive'])->middleware($middleware);
                Route::post('remove/{id}', [Api\ApiV1Dot1Controller::class, 'unarchive'])->middleware($middleware);
                Route::get('list', [Api\ApiV1Dot1Controller::class, 'archivedPosts'])->middleware($middleware);
            });

            Route::prefix('collections')->group(function () use ($middleware) {
                Route::get('accounts/{id}', [CollectionController::class, 'getUserCollections'])->middleware($middleware);
                Route::get('items/{id}', [CollectionController::class, 'getItems'])->middleware($middleware);
                Route::get('view/{id}', [CollectionController::class, 'getCollection'])->middleware($middleware);
                Route::post('add', [CollectionController::class, 'storeId'])->middleware($middleware);
                Route::post('update/{id}', [CollectionController::class, 'store'])->middleware($middleware);
                Route::delete('delete/{id}', [CollectionController::class, 'delete'])->middleware($middleware);
                Route::post('remove', [CollectionController::class, 'deleteId'])->middleware($middleware);
                Route::get('self', [CollectionController::class, 'getSelfCollections'])->middleware($middleware);
            });

            Route::prefix('compose')->group(function () use ($middleware) {
                Route::get('search/location', [ComposeController::class, 'searchLocation'])->middleware($middleware);
                Route::get('settings', [ComposeController::class, 'composeSettings'])->middleware($middleware);
            });

            Route::prefix('direct')->group(function () use ($middleware) {
                Route::get('thread', [DirectMessageController::class, 'thread'])->middleware($middleware);
                Route::post('thread/send', [DirectMessageController::class, 'create'])->middleware($middleware);
                Route::delete('thread/message', [DirectMessageController::class, 'delete'])->middleware($middleware);
                Route::post('thread/mute', [DirectMessageController::class, 'mute'])->middleware($middleware);
                Route::post('thread/unmute', [DirectMessageController::class, 'unmute'])->middleware($middleware);
                Route::post('thread/media', [DirectMessageController::class, 'mediaUpload'])->middleware($middleware);
                Route::post('thread/read', [DirectMessageController::class, 'read'])->middleware($middleware);
                Route::post('lookup', [DirectMessageController::class, 'composeLookup'])->middleware($middleware);
            });

            Route::prefix('discover')->group(function () use ($middleware) {
                Route::get('accounts/popular', [Api\ApiV1Controller::class, 'discoverAccountsPopular'])->middleware($middleware);
                Route::get('posts/trending', [DiscoverController::class, 'trendingApi'])->middleware($middleware);
                Route::get('posts/hashtags', [DiscoverController::class, 'trendingHashtags'])->middleware($middleware);
            });

            Route::prefix('directory')->group(function () {
                Route::get('listing', [PixelfedDirectoryController::class, 'get']);
            });

            Route::prefix('places')->group(function () use ($middleware) {
                Route::get('posts/{id}/{slug}', [Api\ApiV1Dot1Controller::class, 'placesById'])->middleware($middleware);
            });

            Route::get('web/settings', [Api\ApiV1Dot1Controller::class, 'getWebSettings'])->middleware($middleware);
            Route::post('web/settings', [Api\ApiV1Dot1Controller::class, 'setWebSettings'])->middleware($middleware);
            Route::get('app/settings', [UserAppSettingsController::class, 'get'])->middleware($middleware);
            Route::post('app/settings', [UserAppSettingsController::class, 'store'])->middleware($middleware);

            Route::prefix('stories')->group(function () use ($middleware) {
                Route::get('carousel', [Stories\StoryApiV1Controller::class, 'carousel'])->middleware($middleware);
                Route::get('self-carousel', [Stories\StoryApiV1Controller::class, 'selfCarousel'])->middleware($middleware);
                Route::post('add', [Stories\StoryApiV1Controller::class, 'add'])->middleware($middleware);
                Route::post('publish', [Stories\StoryApiV1Controller::class, 'publish'])->middleware($middleware);
                Route::post('seen', [Stories\StoryApiV1Controller::class, 'viewed'])->middleware($middleware);
                Route::post('self-expire/{id}', [Stories\StoryApiV1Controller::class, 'delete'])->middleware($middleware);
                Route::post('comment', [Stories\StoryApiV1Controller::class, 'comment'])->middleware($middleware);
                Route::get('viewers', [Stories\StoryApiV1Controller::class, 'viewers'])->middleware($middleware);
            });
        });
    });
});
