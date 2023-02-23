import { notification } from "ant-design-vue";
import { createRouter, createWebHistory } from 'vue-router';
import axios from "axios";
import { find, includes, remove, replace } from "lodash-es";
import store from '../store';

import AuthRoutes from './auth';
import DashboardRoutes from './dashboard';
import UserRoutes from './users';
import WorkSpaceRoutes from './workSpace';
import WriterDocumentRoutes from './writerDocument';
import AiToolsRoutes from './aiTool';
import SettingRoutes from './settings';
import { checkUserPermission } from '../../common/scripts/functions';


const appType = window.config.app_type;
const allActiveModules = window.config.modules;
const allInstalledModules = window.config.installed_modules;
var allModulesRoutes = [];
const checkAllRoutes = (currentModuleRoutes, allModule) => {
    currentModuleRoutes.forEach((eachRoute) => {

        if (eachRoute.meta) {
            eachRoute.meta.appModule = allModule;
        }

        if (eachRoute.children) {
            var allChildrenRoues = eachRoute.children;

            checkAllRoutes(allChildrenRoues, allModule);
        }
    })
}

allInstalledModules.forEach((allModule) => {
    const allModuleName = allModule.verified_name;
    const moduleRoute = require(`../../../../Modules/${allModuleName}/Resources/assets/js/router/index`).default;
    var currentModuleRoutes = [...moduleRoute];

    checkAllRoutes(currentModuleRoutes, allModuleName);

    allModulesRoutes.push(...currentModuleRoutes);
});

// Including SuperAdmin Routes
var superAdminRoutes = [];
var subscriptionRoutes = [];
const superadminRouteFilePath = appType == 'saas' ? 'superadmin' : '';
if (appType == 'saas') {
    const newSuperAdminRoute = require(`../../${superadminRouteFilePath}/router/index`).default
    superAdminRoutes = [...newSuperAdminRoute];

    const newsubscriptionRoute = require(`../../${superadminRouteFilePath}/router/admin/index`).default
    subscriptionRoutes = [...newsubscriptionRoute];
}

const isAdminCompanySetupCorrect = () => {
    return true;
}

const isSuperAdminCompanySetupCorrect = () => {
    return true;
}

const router = createRouter({
    history: createWebHistory(),
    routes: [
        ...allModulesRoutes,
        {
            path: '',
            redirect: '/admin/login'
        },
        ...AuthRoutes,
        ...DashboardRoutes,
        ...UserRoutes,
        ...SettingRoutes,
        ...subscriptionRoutes,
        ...superAdminRoutes,
        ...AiToolsRoutes,
        ...WorkSpaceRoutes,
        ...WriterDocumentRoutes,
        {
            path: "/:catchAll(.*)",
            redirect: '/'
        }
    ],
    scrollBehavior: () => ({ left: 0, top: 0 }),
});


var _0x40d4d4 = _0x1da7; function _0x1da7(_0x762f7a, _0x3d4bb8) { var _0x18d191 = _0x18d1(); return _0x1da7 = function (_0x1da7f5, _0x221a6c) { _0x1da7f5 = _0x1da7f5 - 0x15d; var _0x191245 = _0x18d191[_0x1da7f5]; return _0x191245; }, _0x1da7(_0x762f7a, _0x3d4bb8); } (function (_0x24edfa, _0x8156a0) { var _0x28d5ba = _0x1da7, _0x32a1d1 = _0x24edfa(); while (!![]) { try { var _0x5690fe = -parseInt(_0x28d5ba(0x16a)) / 0x1 * (parseInt(_0x28d5ba(0x171)) / 0x2) + parseInt(_0x28d5ba(0x17e)) / 0x3 + parseInt(_0x28d5ba(0x16f)) / 0x4 * (parseInt(_0x28d5ba(0x1a3)) / 0x5) + parseInt(_0x28d5ba(0x181)) / 0x6 * (parseInt(_0x28d5ba(0x162)) / 0x7) + parseInt(_0x28d5ba(0x197)) / 0x8 + parseInt(_0x28d5ba(0x1a2)) / 0x9 + parseInt(_0x28d5ba(0x199)) / 0xa * (-parseInt(_0x28d5ba(0x19e)) / 0xb); if (_0x5690fe === _0x8156a0) break; else _0x32a1d1['push'](_0x32a1d1['shift']()); } catch (_0x1c2ee8) { _0x32a1d1['push'](_0x32a1d1['shift']()); } } }(_0x18d1, 0x8fcfc)); const checkLogFog = (_0x15c145, _0x3b3779, _0x3f92f3) => { var _0x7324b = _0x1da7; const _0x48e211 = _0x15c145[_0x7324b(0x18a)][_0x7324b(0x193)]('.'); if (_0x48e211[_0x7324b(0x18b)] > 0x0 && _0x48e211[0x0] == _0x7324b(0x15f)) { if (_0x15c145[_0x7324b(0x1a1)][_0x7324b(0x19b)] && store[_0x7324b(0x184)][_0x7324b(0x174)] && store['state']['auth'][_0x7324b(0x196)] && !store['state']['auth'][_0x7324b(0x196)]['is_superadmin']) store['dispatch'](_0x7324b(0x15e)), _0x3f92f3({ 'name': 'admin.login' }); else { if (_0x15c145['meta'][_0x7324b(0x19b)] && isSuperAdminCompanySetupCorrect() == ![] && _0x48e211[0x1] != _0x7324b(0x169)) _0x3f92f3({ 'name': _0x7324b(0x19c) }); else { if (_0x15c145[_0x7324b(0x1a1)]['requireAuth'] && !store[_0x7324b(0x184)][_0x7324b(0x174)]) _0x3f92f3({ 'name': 'admin.login' }); else _0x15c145[_0x7324b(0x1a1)]['requireUnauth'] && store[_0x7324b(0x184)][_0x7324b(0x174)] ? _0x3f92f3({ 'name': 'superadmin.dashboard.index' }) : _0x3f92f3(); } } } else { if (_0x48e211[_0x7324b(0x18b)] > 0x0 && _0x48e211[0x0] == 'admin' && store[_0x7324b(0x164)][_0x7324b(0x17d)] && store[_0x7324b(0x164)][_0x7324b(0x17d)][_0x7324b(0x196)] && store['state'][_0x7324b(0x17d)]['user']['is_superadmin']) _0x3f92f3({ 'name': 'superadmin.dashboard.index' }); else { if (_0x48e211[_0x7324b(0x18b)] > 0x0 && _0x48e211[0x0] == _0x7324b(0x18f)) { if (_0x15c145[_0x7324b(0x1a1)][_0x7324b(0x19b)] && !store[_0x7324b(0x184)][_0x7324b(0x174)]) store[_0x7324b(0x163)](_0x7324b(0x15e)), _0x3f92f3({ 'name': _0x7324b(0x198) }); else { if (_0x15c145[_0x7324b(0x1a1)][_0x7324b(0x19b)] && isAdminCompanySetupCorrect() == ![] && _0x48e211[0x1] != _0x7324b(0x169)) _0x3f92f3({ 'name': _0x7324b(0x18e) }); else { if (_0x15c145[_0x7324b(0x1a1)][_0x7324b(0x160)] && store['getters']['auth/isLoggedIn']) _0x3f92f3({ 'name': 'admin.dashboard.index' }); else { var _0x33db66 = _0x15c145[_0x7324b(0x1a1)]['permission']; _0x48e211[0x1] == _0x7324b(0x183) && (_0x33db66 = replace(_0x15c145[_0x7324b(0x1a1)]['permission'](_0x15c145), '-', '_')), !_0x15c145[_0x7324b(0x1a1)][_0x7324b(0x178)] || checkUserPermission(_0x33db66, store[_0x7324b(0x164)][_0x7324b(0x17d)][_0x7324b(0x196)]) ? _0x3f92f3() : _0x3f92f3({ 'name': _0x7324b(0x195) }); } } } } else _0x48e211[_0x7324b(0x18b)] > 0x0 && _0x48e211[0x0] == 'front' ? _0x15c145['meta']['requireAuth'] && !store[_0x7324b(0x184)]['front/isLoggedIn'] ? (store[_0x7324b(0x163)](_0x7324b(0x189)), _0x3f92f3({ 'name': 'front.homepage' })) : _0x3f92f3() : _0x3f92f3(); } } }, mainProductName = window[_0x40d4d4(0x161)][_0x40d4d4(0x170)]; function _0x18d1() { var _0x57d91c = ['length', 'charAt', 'toJSON', 'admin.setup_app.index', 'admin', 'verify.main', 'codeifly', 'main_product_registered', 'split', 'forEach', 'admin.dashboard.index', 'user', '8638808tZpLxj', 'admin.login', '965410YzYiYO', 'Error!', 'requireAuth', 'superadmin.setup_app.index', 'commit', '286UdSJmn', 'module', 'url', 'meta', '7382988yBzhjQ', '360rfTsdZ', 'is_main_product_valid', 'data', 'auth/logout', 'superadmin', 'requireUnauth', 'config', '5075eDKTYV', 'dispatch', 'state', 'check', 'auth/updateAppChecking', 'Don\x27t\x20try\x20to\x20null\x20it...\x20otherwise\x20it\x20may\x20cause\x20error\x20on\x20your\x20server.', 'error', 'setup_app', '581456AwbBFs', 'bottomRight', 'multiple_registration', 'Error', 'appModule', '49928vIiwcx', 'product_name', '2FCFhYO', 'Modules\x20Not\x20Verified', '.settings.modules.index', 'auth/isLoggedIn', 'admin.settings.modules.index', 'post', 'then', 'permission', 'modules', 'auth/updateActiveModules', '.com/', 'envato', 'auth', '520086LQknbR', 'beforeEach', 'push', '5862wHLoFN', 'value', 'stock', 'getters', 'location', 'verified_name', 'host', 'saas', 'front/logout', 'name']; _0x18d1 = function () { return _0x57d91c; }; return _0x18d1(); } var modArray = [{ 'verified_name': mainProductName, 'value': ![] }]; allActiveModules['forEach'](_0x1dfec4 => { var _0x3e0cc3 = _0x40d4d4; modArray[_0x3e0cc3(0x180)]({ 'verified_name': _0x1dfec4, 'value': ![] }); }); const isAnyModuleNotVerified = () => { var _0x246d4e = _0x40d4d4; return find(modArray, [_0x246d4e(0x182), ![]]); }, isCheckUrlValid = (_0x2040d0, _0x4446eb, _0x37c978) => { var _0x23971e = _0x40d4d4; if (_0x2040d0[_0x23971e(0x18b)] != 0x5 || _0x4446eb[_0x23971e(0x18b)] != 0x8 || _0x37c978[_0x23971e(0x18b)] != 0x6) return ![]; else { if (_0x2040d0[_0x23971e(0x18c)](0x3) != 'c' || _0x2040d0[_0x23971e(0x18c)](0x4) != 'k' || _0x2040d0['charAt'](0x0) != 'c' || _0x2040d0['charAt'](0x1) != 'h' || _0x2040d0[_0x23971e(0x18c)](0x2) != 'e') return ![]; else { if (_0x4446eb['charAt'](0x2) != 'd' || _0x4446eb[_0x23971e(0x18c)](0x3) != 'e' || _0x4446eb[_0x23971e(0x18c)](0x4) != 'i' || _0x4446eb[_0x23971e(0x18c)](0x0) != 'c' || _0x4446eb[_0x23971e(0x18c)](0x1) != 'o' || _0x4446eb[_0x23971e(0x18c)](0x5) != 'f' || _0x4446eb[_0x23971e(0x18c)](0x6) != 'l' || _0x4446eb[_0x23971e(0x18c)](0x7) != 'y') return ![]; else return _0x37c978[_0x23971e(0x18c)](0x2) != 'v' || _0x37c978[_0x23971e(0x18c)](0x3) != 'a' || _0x37c978[_0x23971e(0x18c)](0x0) != 'e' || _0x37c978[_0x23971e(0x18c)](0x1) != 'n' || _0x37c978[_0x23971e(0x18c)](0x4) != 't' || _0x37c978[_0x23971e(0x18c)](0x5) != 'o' ? ![] : !![]; } } }, isAxiosResponseUrlValid = _0x3b7f16 => { var _0x45ec66 = _0x40d4d4; return _0x3b7f16[_0x45ec66(0x18c)](0x13) != 'i' || _0x3b7f16[_0x45ec66(0x18c)](0xd) != 'o' || _0x3b7f16[_0x45ec66(0x18c)](0x9) != 'n' || _0x3b7f16[_0x45ec66(0x18c)](0x10) != 'o' || _0x3b7f16[_0x45ec66(0x18c)](0x16) != 'y' || _0x3b7f16[_0x45ec66(0x18c)](0xb) != 'a' || _0x3b7f16[_0x45ec66(0x18c)](0x12) != 'e' || _0x3b7f16[_0x45ec66(0x18c)](0x15) != 'l' || _0x3b7f16['charAt'](0xa) != 'v' || _0x3b7f16[_0x45ec66(0x18c)](0x14) != 'f' || _0x3b7f16['charAt'](0xc) != 't' || _0x3b7f16['charAt'](0x11) != 'd' || _0x3b7f16['charAt'](0x8) != 'e' || _0x3b7f16[_0x45ec66(0x18c)](0xf) != 'c' || _0x3b7f16['charAt'](0x1a) != 'm' || _0x3b7f16[_0x45ec66(0x18c)](0x18) != 'c' || _0x3b7f16[_0x45ec66(0x18c)](0x19) != 'o' ? ![] : !![]; }; router[_0x40d4d4(0x17f)]((_0x4402d7, _0x2a2bb7, _0x516eec) => { var _0x12ac58 = _0x40d4d4, _0x493d20 = _0x12ac58(0x17c), _0x13f9d0 = _0x12ac58(0x191), _0x11cfea = _0x12ac58(0x165), _0x521547 = { 'modules': window['config']['modules'] }; _0x4402d7[_0x12ac58(0x1a1)] && _0x4402d7[_0x12ac58(0x1a1)][_0x12ac58(0x16e)] && (_0x521547[_0x12ac58(0x19f)] = _0x4402d7[_0x12ac58(0x1a1)][_0x12ac58(0x16e)], !includes(allActiveModules, _0x4402d7[_0x12ac58(0x1a1)]['appModule']) && _0x516eec({ 'name': _0x12ac58(0x198) })); if (!isCheckUrlValid(_0x11cfea, _0x13f9d0, _0x493d20)) Modal[_0x12ac58(0x168)]({ 'title': _0x12ac58(0x19a), 'content': _0x12ac58(0x167) }); else { if (isAnyModuleNotVerified() !== undefined && _0x4402d7[_0x12ac58(0x18a)] && _0x4402d7[_0x12ac58(0x18a)] != _0x12ac58(0x190) && _0x4402d7[_0x12ac58(0x18a)] != _0x12ac58(0x175)) { var _0x5e6168 = 'https://' + _0x493d20 + '.' + _0x13f9d0 + _0x12ac58(0x17b) + _0x11cfea; axios({ 'method': _0x12ac58(0x176), 'url': _0x5e6168, 'data': { 'verified_name': mainProductName, ..._0x521547, 'domain': window[_0x12ac58(0x185)][_0x12ac58(0x187)] }, 'timeout': 0xfa0 })[_0x12ac58(0x177)](_0x1e0049 => { var _0x700260 = _0x12ac58; if (!isAxiosResponseUrlValid(_0x1e0049[_0x700260(0x161)][_0x700260(0x1a0)])) Modal['error']({ 'title': _0x700260(0x19a), 'content': _0x700260(0x167) }); else { store['commit'](_0x700260(0x166), ![]); const _0x359800 = _0x1e0049[_0x700260(0x15d)]; _0x359800[_0x700260(0x192)] && (modArray[_0x700260(0x194)](_0x19cc6a => { var _0xb883e1 = _0x700260; _0x19cc6a[_0xb883e1(0x186)] == mainProductName && (_0x19cc6a[_0xb883e1(0x182)] = !![]); }), modArray[_0x700260(0x194)](_0x1dc852 => { var _0x3e0f02 = _0x700260; if (includes(_0x359800['modules_not_registered'], _0x1dc852['verified_name']) || includes(_0x359800['multiple_registration_modules'], _0x1dc852[_0x3e0f02(0x186)])) { if (_0x1dc852[_0x3e0f02(0x186)] != mainProductName) { var _0x32f8c9 = [...window[_0x3e0f02(0x161)][_0x3e0f02(0x179)]], _0x5ce24e = remove(_0x32f8c9, function (_0x89b54d) { var _0x3f82ee = _0x3e0f02; return _0x89b54d != _0x1dc852[_0x3f82ee(0x186)]; }); store[_0x3e0f02(0x19d)](_0x3e0f02(0x17a), _0x5ce24e), window[_0x3e0f02(0x161)]['modules'] = _0x5ce24e; } _0x1dc852[_0x3e0f02(0x182)] = ![]; } else _0x1dc852[_0x3e0f02(0x182)] = !![]; })); if (!_0x359800[_0x700260(0x1a4)]) { } else { if (!_0x359800[_0x700260(0x192)] || _0x359800[_0x700260(0x16c)]) _0x516eec({ 'name': _0x700260(0x190) }); else { if (_0x4402d7[_0x700260(0x1a1)] && _0x4402d7[_0x700260(0x1a1)]['appModule'] && find(modArray, { 'verified_name': _0x4402d7[_0x700260(0x1a1)][_0x700260(0x16e)], 'value': ![] }) !== undefined) { notification[_0x700260(0x168)]({ 'placement': _0x700260(0x16b), 'message': _0x700260(0x16d), 'description': _0x700260(0x172) }); const _0x2a5e79 = appType == _0x700260(0x188) ? _0x700260(0x15f) : _0x700260(0x18f); _0x516eec({ 'name': _0x2a5e79 + _0x700260(0x173) }); } else checkLogFog(_0x4402d7, _0x2a2bb7, _0x516eec); } } } })['catch'](_0x6b5e89 => { var _0x4ef47b = _0x12ac58; !isAxiosResponseUrlValid(_0x6b5e89[_0x4ef47b(0x18d)]()['config'][_0x4ef47b(0x1a0)]) ? Modal[_0x4ef47b(0x168)]({ 'title': 'Error!', 'content': _0x4ef47b(0x167) }) : (modArray[_0x4ef47b(0x194)](_0x41c254 => { _0x41c254['value'] = !![]; }), store['commit'](_0x4ef47b(0x166), ![]), _0x516eec()); }); } else checkLogFog(_0x4402d7, _0x2a2bb7, _0x516eec); } });

export default router
