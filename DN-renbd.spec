Name:   DN-renbd
Version:   1.0.0
Release: 1
Summary:  钉钉消息推送小工具

Group:    Development/Libraries 
License:  GPL
URL:  https://github.com/renbingdong/DingNotice.git
Source0:  %{name}.tar.gz

BuildRoot: %{_tmppath}/%{name}-%{version}
BuildArch: noarch

#制作rpm过程中依赖的软件包
#BuildRequires:

#运行所需要依赖的软件包
#Requires:  

%description
使用工具，快速将系统异常信息推送到钉钉群中，以便技术员及时发现问题

##预处理
%prep
%setup -q -c %{name}-%{version}


##构建
%build


##安装
%install
rm -rf %{buildroot}
mkdir -p %{getenv:HOME}/%{name}
cp -r * %{getenv:HOME}/%{name}

##清理
%clean
rm -rf %{buildroot}

##rpm包包含的文件
%files


##变更日志
%changelog
