<?php

namespace App\Helper;

/**
 * Class Pcntl
 *
 * @package Pcntl
 */
class Pcntl
{
    /**
     * Alarm
     *
     * @param int $seconds The number of seconds to wait. If seconds is zero, no new alarm is created.
     *
     * @return int The time in seconds that any previously scheduled alarm had remaining before it was to be delivered, or 0 if there was no previously scheduled alarm.
     */
    public function alarm($seconds)
    {
        return pcntl_alarm($seconds);
    }

    /**
     * Errno
     *
     * This function is an alias of: $this->strerror()
     */
    public function errno()
    {
        return $this->strerror();
    }

    /**
     * Exec
     *
     * @param string $path The path to a binary executable or a script with a valid path pointing to an executable in the shebang
     * @param array  $args Array of argument strings passed to the program.
     * @param array  $envs Array of strings which are passed as environment to the program
     *
     * @return null|bool Returns FALSE on error and does not return on success.
     */
    public function exec($path, array $args = array(), array $envs = array())
    {
        return pcntl_exec($path, $args, $envs);
    }

    /**
     * Fork
     *
     * On success, the PID of the child process is returned in the parent's thread of execution,
     * and a 0 is returned in the child's thread of execution. On failure,
     * a -1 will be returned in the parent's context, no child process will be created, and a PHP error is raised.
     *
     * @return int
     */
    public function fork()
    {
        return pcntl_fork();
    }

    /**
     * Get Last Error
     *
     * @return int Returns error code.
     */
    public function getLastError()
    {
        return pcntl_get_last_error();
    }

    /**
     * Get Priority
     *
     * @param int $pid               If not specified, the pid of the current process is used.
     * @param int $processIdentifier One of PRIO_PGRP, PRIO_USER or PRIO_PROCESS.
     *
     * @return int The priority of the process or FALSE on error. A lower numerical value causes more favorable scheduling.
     */
    public function getPriority($pid = null, $processIdentifier = PRIO_PROCESS)
    {
        if (is_null($pid)) {
            $pid = getmypid();
        }

        return pcntl_getpriority($pid, $processIdentifier);
    }

    /**
     * Set Priority
     *
     * @param int $priority          Generally a value in the range -20 to 20. The default priority is 0 while a lower numerical value causes more favorable scheduling.
     * @param int $pid               If not specified, the pid of the current process is used.
     * @param int $processIdentifier One of PRIO_PGRP, PRIO_USER or PRIO_PROCESS.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function setPriority($priority, $pid = null, $processIdentifier = PRIO_PROCESS)
    {
        return pcntl_setpriority($priority, $pid, $processIdentifier);
    }

    /**
     * Signal Dispatch
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function signalDispatch()
    {
        return pcntl_signal_dispatch();
    }

    /**
     * @param int          $signo           The signal number.
     * @param callable|int $handler         The signal handler. This may be either a callable, which will be invoked to handle the signal, or either of the two global constants SIG_IGN or SIG_DFL, which will ignore the signal or restore the default signal handler respectively.
     * @param bool         $restartSysCalls Specifies whether system call restarting should be used when this signal arrives.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function signal($signo, $handler, $restartSysCalls = true)
    {
        return pcntl_signal($signo, $handler, $restartSysCalls);
    }

    /**
     * Sig Proc Mask
     *
     * @param int   $how    Sets the behavior of pcntl_sigprocmask(). Possible values: SIG_BLOCK, SIG_UNBLOCK, SIG_SETMASK
     * @param array $set    List of signals.
     * @param array $oldSet The oldset parameter is set to an array containing the list of the previously blocked signals.
     *
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function sigProcMask($how, array $set, array $oldSet = array())
    {
        return pcntl_sigprocmask($how, $set, $oldSet);
    }

    /**
     * Sig Timed Wait
     *
     * @param array $set         Array of signals to wait for.
     * @param array $sigInfo     The siginfo is set to an array containing informations about the signal. See pcntl_sigwaitinfo().
     * @param int   $seconds     Timeout in seconds.
     * @param int   $nanoseconds Timeout in nanoseconds.
     *
     * @return int  On success, pcntl_sigtimedwait() returns a signal number.
     */
    public function sigTimedWait(array $set, array $sigInfo, $seconds = 0, $nanoseconds = 0)
    {
        return pcntl_sigtimedwait($set, $sigInfo, $seconds, $nanoseconds);
    }

    /**
     * Sig Wait Info
     *
     * @param array $set     Array of signals to wait for.
     * @param array $siginfo The siginfo parameter is set to an array containing informations about the signal.
     *
     * @return int On success, pcntl_sigwaitinfo() returns a signal number.
     */
    public function sigWaitInfo(array $set, array $siginfo)
    {
        return pcntl_sigwaitinfo($set, $siginfo);
    }

    /**
     * Str Error
     *
     * @param $errno Error Number
     *
     * @return string|bool Returns error description on success or FALSE on failure.
     */
    public function strError($errno)
    {
        return pcntl_strerror($errno);
    }

    /**
     * Wait
     *
     * @param int $status  pcntl_wait() will store status information in the status parameter
     * @param int $options If wait3 is available on your system (mostly BSD-style systems), you can provide the optional options parameter
     *
     * @return int the process ID of the child which exited, -1 on error or zero if WNOHANG was provided as an option (on wait3-available systems) and no child was available.
     */
    public function wait($status, $options = 0)
    {
        return pcntl_wait($status, $options);
    }

    /**
     * Wait Pid
     *
     * @param int $pid     The Process ID
     * @param int $status  pcntl_waitpid() will store status information in the status parameter which can be evaluated using the following functions
     * @param int $options The value of options is the value of zero or more of the following two global constants OR'ed together:
     *
     * @return int returns the process ID of the child which exited, -1 on error or zero if WNOHANG was used and no child was available
     */
    public function waitPid($pid, $status, $options = 0)
    {
        return pcntl_waitpid($pid, $status, $options);
    }

    /**
     * W Exit Status
     *
     * @param $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return int Returns the return code, as an integer.
     */
    public function wExitStatus($status)
    {
        return pcntl_wexitstatus($status);
    }

    /**
     * W If Exited
     * @param $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return bool Returns TRUE if the child status code represents a normal exit, FALSE otherwise.
     */
    public function wIfExited($status)
    {
        return pcntl_wifexited($status);
    }

    /**
     * W IF Signaled
     *
     * @param $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return bool Returns TRUE if the child process exited because of a signal which was not caught, FALSE otherwise.
     */
    public function wIdSignaled($status)
    {
        return pcntl_wifsignaled($status);
    }

    /**
     * W If Stopped
     *
     * @param $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return bool Returns TRUE if the child process which caused the return is currently stopped, FALSE otherwise.
     */
    public function wIfStopped($status)
    {
        return pcntl_wifstopped($status);
    }

    /**
     * W Stop Sig
     *
     * @param $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return int Returns the signal number.
     */
    public function wStopSig($status)
    {
        return pcntl_wstopsig($status);
    }

    /**
     * W Term Sig
     *
     * @param $status The status parameter is the status parameter supplied to a successful call to pcntl_waitpid().
     *
     * @return int Returns the signal number, as an integer.
     */
    public function wTermSig($status)
    {
        return pcntl_wtermsig($status);
    }
}
